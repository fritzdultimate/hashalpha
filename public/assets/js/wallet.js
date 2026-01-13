/**
 * HashAlpha Wallet Integration Module
 * Handles Web3 connection, account management, and UI state updates.
 */

const AppState = {
    userAddress: null,
    isConnected: false
};

const Elements = {
    connectBtn: document.getElementById('connect-wallet-btn'),
    walletError: document.getElementById('wallet-error'),
    connectedState: document.getElementById('connected-state'),
    walletAddressDisplay: document.getElementById('wallet-address'),
    
    // Status Cards
    statusWaiting: document.getElementById('status-waiting'),
    statusChecking: document.getElementById('status-checking'),
    statusNotQualified: document.getElementById('status-not-qualified'),
    statusQualified: document.getElementById('status-qualified')
};

/**
 * Initiates the wallet connection flow
 */
async function connectWallet() {
    if (typeof window.ethereum === 'undefined') {
        alert("Please install MetaMask or a Web3 Wallet extension!");
        return;
    }

    // Save original button state
    const originalText = `
            <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg> Connect Wallet`;
    
    // Set Loading State
    Elements.connectBtn.innerText = 'Connecting...';
    Elements.connectBtn.disabled = true;
    Elements.walletError.classList.add('hidden');

    try {
        // Handle multiple providers (EIP-6963 support)
        let provider = window.ethereum;
        if (window.ethereum.providers?.length) {
            provider = window.ethereum.providers.find(p => p.isMetaMask) || window.ethereum.providers[0];
        }

        // Request Accounts with Timeout
        const accounts = await Promise.race([
            provider.request({ method: 'eth_requestAccounts' }),
            new Promise((_, reject) => setTimeout(() => reject(new Error('Connection timed out. Please check your wallet extension.')), 15000))
        ]);

        handleAccountsChanged(accounts);

    } catch (error) {
        console.error('Wallet Connection Error:', error);
        
        let msg = error.message || "Unknown error";
        if (msg.includes('user rejected')) msg = "Connection rejected by user.";
        if (msg.includes('Unexpected error')) msg = "Wallet extension error. Please unlock your wallet and try again.";

        // Show Error
        Elements.walletError.innerText = msg;
        Elements.walletError.classList.remove('hidden');
        
        // Reset Button
        Elements.connectBtn.innerHTML = originalText;
        Elements.connectBtn.disabled = false;
    }
}

/**
 * Standard Web3 Account Change Handler
 */
function handleAccountsChanged(accounts) {
    if (accounts.length === 0) {
        disconnectWallet();
    } else {
        AppState.userAddress = accounts[0];
        AppState.isConnected = true;
        updateUI(true);
        checkEligibility(AppState.userAddress);
    }
}

/**
 * Updates the UI based on connection state
 */
function updateUI(connected) {
    if (connected) {
        Elements.connectBtn.classList.add('hidden');
        Elements.connectedState.classList.remove('hidden');
        Elements.walletAddressDisplay.innerText = AppState.userAddress.slice(0, 6) + '...' + AppState.userAddress.slice(-4);
    } else {
        Elements.connectBtn.classList.remove('hidden');
        Elements.connectBtn.innerHTML = `
            <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg> Connect Wallet`;
        Elements.connectBtn.disabled = false;
        Elements.connectedState.classList.add('hidden');
        
        // Reset Status Card to Waiting
        Elements.statusWaiting.classList.remove('hidden');
        Elements.statusChecking.classList.add('hidden');
        Elements.statusNotQualified.classList.add('hidden');
        Elements.statusQualified.classList.add('hidden');
    }
}

/**
 * Resets application state
 */
function disconnectWallet() {
    AppState.userAddress = null;
    AppState.isConnected = false;
    updateUI(false);
}

/**
 * Simulates backend eligibility check
 */
async function checkEligibility(address) {
    // Show Checking Spinner
    Elements.statusWaiting.classList.add('hidden');
    Elements.statusChecking.classList.remove('hidden');

    // Simulate Network Delay
    setTimeout(() => {
        Elements.statusChecking.classList.add('hidden');
        
        // Check for ?qualified=1 override for debugging
        const forceQualified = new URLSearchParams(window.location.search).has('qualified');
        
        if (forceQualified) {
            Elements.statusQualified.classList.remove('hidden');
        } else {
            // Default Pre-Launch State
            Elements.statusNotQualified.classList.remove('hidden');
        }
    }, 1500);
}

// Auto-Initialize
if (typeof window.ethereum !== 'undefined') {
    window.ethereum.on('accountsChanged', handleAccountsChanged);
}
