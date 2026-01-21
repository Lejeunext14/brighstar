#!/bin/bash
# BrightStar Installation Script for Android (Capacitor)
# This script sets up BrightStar as an Android app

echo ""
echo "================================================"
echo "  BrightStar Installation for Android"
echo "================================================"
echo ""

# Check if Node.js is installed
if ! command -v node &> /dev/null; then
    echo "[ERROR] Node.js is not installed"
    echo "Please install Node.js from https://nodejs.org/"
    exit 1
fi

# Check if npm is installed
if ! command -v npm &> /dev/null; then
    echo "[ERROR] npm is not installed"
    exit 1
fi

# Check if Java is installed (for Android SDK)
if ! command -v java &> /dev/null; then
    echo "[ERROR] Java is not installed"
    echo "Please install Java JDK from https://www.oracle.com/java/technologies/downloads/"
    exit 1
fi

echo "[OK] All prerequisites found"
echo ""

# Install Node dependencies
echo "[1/5] Installing Node dependencies..."
npm install
if [ $? -ne 0 ]; then
    echo "[ERROR] npm install failed"
    exit 1
fi

# Install Capacitor
echo "[2/5] Installing Capacitor CLI..."
npm install -g @capacitor/cli @capacitor/core
if [ $? -ne 0 ]; then
    echo "[ERROR] Capacitor installation failed"
    exit 1
fi

# Build web assets
echo "[3/5] Building web assets..."
npm run build
if [ $? -ne 0 ]; then
    echo "[ERROR] Build failed"
    exit 1
fi

# Initialize Capacitor project
echo "[4/5] Initializing Capacitor project..."
npx cap init brighstar com.brighstar.app
if [ $? -ne 0 ]; then
    echo "[ERROR] Capacitor init failed"
    exit 1
fi

# Add Android platform
echo "[5/5] Adding Android platform..."
npx cap add android
if [ $? -ne 0 ]; then
    echo "[ERROR] Adding Android platform failed"
    exit 1
fi

echo ""
echo "================================================"
echo "  Installation Complete!"
echo "================================================"
echo ""
echo "Next steps:"
echo "1. Install Android Studio from https://developer.android.com/studio"
echo ""
echo "2. Set up Android SDK in Android Studio"
echo ""
echo "3. Open the Android project:"
echo "   npx cap open android"
echo ""
echo "4. Build and run in Android Studio"
echo ""
echo "5. For development, use:"
echo "   npm run dev   (in one terminal)"
echo "   npx cap sync  (in another terminal)"
echo ""
echo "================================================"
echo ""
