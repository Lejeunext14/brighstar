import { startCharacterInit } from './character-loader.js';

// Initialize character loader when on games page
document.addEventListener('DOMContentLoaded', () => {
    const characterContainer = document.getElementById('character-container');
    if (characterContainer) {
        startCharacterInit();
    }
});
