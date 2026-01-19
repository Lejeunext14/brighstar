<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PhoneVerificationCode;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PhoneVerificationController extends Controller
{
    /**
     * Show page to add/verify phone number
     */
    public function showAddPhone()
    {
        $parent = auth()->user();
        
        return view('pages.parent.add-phone', [
            'parent' => $parent,
            'hasPhone' => !is_null($parent->phone_number),
        ]);
    }

    /**
     * Send verification code to parent's phone
     */
    public function sendVerificationCode(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|regex:/^\+?[1-9]\d{1,14}$/',
        ], [
            'phone_number.required' => 'Phone number is required',
            'phone_number.regex' => 'Please enter a valid phone number (e.g., +1234567890)',
        ]);

        $parent = auth()->user();
        $phoneNumber = $request->phone_number;

        // Check if this phone is already in use by another parent
        if (User::where('phone_number', $phoneNumber)->where('id', '!=', $parent->id)->exists()) {
            throw ValidationException::withMessages([
                'phone_number' => 'This phone number is already registered.',
            ]);
        }

        // Generate verification code
        $code = PhoneVerificationCode::generateCode();
        
        // Create verification record
        PhoneVerificationCode::create([
            'user_id' => $parent->id,
            'code' => $code,
            'type' => 'phone_verification',
            'target_phone' => $phoneNumber,
            'expires_at' => now()->addMinutes(15),
        ]);

        // Send SMS (you'll need to implement this with Twilio, AWS SNS, etc.)
        $this->sendSMS($phoneNumber, "Your verification code is: {$code}. Valid for 15 minutes.");

        return back()
            ->with('status', 'Verification code sent to ' . $this->maskPhone($phoneNumber))
            ->with('test_code', $code); // For testing/development
    }

    /**
     * Verify the phone code
     */
    public function verifyPhoneCode(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $parent = auth()->user();
        $code = $request->code;

        // Find valid verification code
        $verification = PhoneVerificationCode::where('user_id', $parent->id)
            ->where('type', 'phone_verification')
            ->where('code', $code)
            ->where('verified', false)
            ->where('expires_at', '>', now())
            ->first();

        if (!$verification) {
            throw ValidationException::withMessages([
                'code' => 'Invalid or expired verification code.',
            ]);
        }

        // Mark as verified and update parent's phone
        $verification->update(['verified' => true]);
        $parent->update(['phone_number' => $verification->target_phone]);

        return redirect()->route('parent.link-child')->with('success', 'Phone verified successfully!');
    }

    /**
     * Show page for linking child
     */
    public function showLinkChild()
    {
        $parent = auth()->user();

        if (!$parent->phone_number) {
            return redirect()->route('phone.verify')->with('warning', 'Please verify your phone number first.');
        }

        $children = $parent->children()->get();

        return view('pages.parent.link-child', [
            'parent' => $parent,
            'children' => $children,
        ]);
    }

    /**
     * Generate linking code for child
     */
    public function generateLinkingCode(Request $request)
    {
        $request->validate([
            'child_phone' => 'required|regex:/^\+?[1-9]\d{1,14}$/',
        ]);

        $parent = auth()->user();
        
        if (!$parent->phone_number) {
            return back()->with('error', 'Please verify your phone number first.');
        }

        // Generate linking code
        $code = PhoneVerificationCode::generateCode();

        PhoneVerificationCode::create([
            'user_id' => $parent->id,
            'code' => $code,
            'type' => 'parent_linking',
            'target_phone' => $request->child_phone,
            'expires_at' => now()->addHours(24),
        ]);

        // Send SMS to child's phone
        $this->sendSMS(
            $request->child_phone,
            "Your parent has sent you a linking code: {$code}. Enter this in the app to link your account. Valid for 24 hours."
        );

        return back()->with('success', 'Linking code sent to ' . $this->maskPhone($request->child_phone));
    }

    /**
     * Child uses linking code to connect to parent
     */
    public function linkWithCode(Request $request)
    {
        $request->validate([
            'linking_code' => 'required|string|size:6',
        ]);

        $child = auth()->user();
        $code = $request->linking_code;

        // Find valid linking code
        $verification = PhoneVerificationCode::where('code', $code)
            ->where('type', 'parent_linking')
            ->where('verified', false)
            ->where('expires_at', '>', now())
            ->first();

        if (!$verification) {
            throw ValidationException::withMessages([
                'linking_code' => 'Invalid or expired linking code.',
            ]);
        }

        // Check if child is already linked to another parent
        if ($child->parent_id && $child->parent_id !== $verification->user_id) {
            throw ValidationException::withMessages([
                'linking_code' => 'You are already linked to another parent.',
            ]);
        }

        // Link child to parent
        $child->update(['parent_id' => $verification->user_id]);
        $verification->update(['verified' => true, 'child_user_id' => $child->id]);

        $parent = $verification->user;

        return redirect()->route('dashboard')->with('success', "Successfully linked to parent: {$parent->name}");
    }

    /**
     * Send SMS using your preferred service
     * Override this to use Twilio, AWS SNS, etc.
     */
    protected function sendSMS(string $phoneNumber, string $message): void
    {
        // TODO: Implement SMS service
        // Example with Twilio:
        // $twilio = new Client(env('TWILIO_ACCOUNT_SID'), env('TWILIO_AUTH_TOKEN'));
        // $twilio->messages->create($phoneNumber, ['from' => env('TWILIO_PHONE_NUMBER'), 'body' => $message]);

        // For now, log it
        \Log::info("SMS to {$phoneNumber}: {$message}");
    }

    /**
     * Mask phone number for display
     */
    protected function maskPhone(string $phone): string
    {
        $last4 = substr($phone, -4);
        return '***' . $last4;
    }
}
