<x-layouts::app.admin :title="__('Admin Settings')">
    <flux:main>
        <div class="w-full">
            <!-- Header -->
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-black text-gray-900 dark:text-white">Settings ⚙️</h1>
                    <p class="mt-2 text-lg text-gray-600 dark:text-gray-300">Configure system settings</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="rounded-lg bg-gray-200 px-4 py-2 text-gray-900 hover:bg-gray-300 dark:bg-neutral-700 dark:text-white dark:hover:bg-neutral-600">← Back</a>
            </div>

            <!-- Settings Sections -->
            <div class="space-y-6">
                <!-- General Settings -->
                <div class="rounded-xl border border-neutral-200 bg-white p-8 dark:border-neutral-700 dark:bg-neutral-900">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">General Settings</h2>
                    <div class="space-y-4">
                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Application Name</label>
                                <input type="text" value="BrightStar" class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-gray-900 dark:border-neutral-600 dark:bg-neutral-800 dark:text-white" disabled>
                            </div>
                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Environment</label>
                                <input type="text" value="Production" class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-gray-900 dark:border-neutral-600 dark:bg-neutral-800 dark:text-white" disabled>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Management Settings -->
                <div class="rounded-xl border border-neutral-200 bg-white p-8 dark:border-neutral-700 dark:bg-neutral-900">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">User Management</h2>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">Enable User Registration</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Allow new users to register</p>
                            </div>
                            <input type="checkbox" checked class="rounded border-gray-300">
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">Enable Email Verification</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Require users to verify their email</p>
                            </div>
                            <input type="checkbox" checked class="rounded border-gray-300">
                        </div>
                    </div>
                </div>

                <!-- Security Settings -->
                <div class="rounded-xl border border-neutral-200 bg-white p-8 dark:border-neutral-700 dark:bg-neutral-900">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Security Settings</h2>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">Enable Two-Factor Authentication</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Require 2FA for admin accounts</p>
                            </div>
                            <input type="checkbox" checked class="rounded border-gray-300">
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">Session Timeout (minutes)</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Automatically logout inactive users</p>
                            </div>
                            <input type="number" value="30" class="w-24 rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-gray-900 dark:border-neutral-600 dark:bg-neutral-800 dark:text-white">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </flux:main>
</x-layouts::app.admin>
