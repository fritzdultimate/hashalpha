@extends('layouts.nft')

@section('contents')

    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar Navigation -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64 bg-black border-r border-gray-900">
                <!-- Logo -->
                <div class="h-16 flex items-center px-6 border-b border-gray-900">
                    <div class="flex items-center space-x-3">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="HashAlpha Logo" class="h-10 w-auto">
                    </div>
                </div>

                <!-- Nav Links -->
                <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
                    <nav class="mt-5 px-4 space-y-2">
                        <a href="#"
                            class="sidebar-item group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-300 hover:text-white transition-colors">
                            <svg class="mr-3 h-6 w-6 text-gray-500 group-hover:text-gray-300" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Dashboard
                        </a>

                        <a href="#"
                            class="sidebar-active group flex items-center px-2 py-2 text-base font-medium text-white transition-colors">
                            <svg class="mr-3 h-6 w-6 text-dark-accent" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            My V-NFTs
                        </a>

                        <a href="#"
                            class="sidebar-item group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-300 hover:text-white transition-colors">
                            <svg class="mr-3 h-6 w-6 text-gray-500 group-hover:text-gray-300" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            History
                        </a>
                    </nav>
                </div>

                <!-- User Profile Stub -->
                <div class="flex-shrink-0 flex border-t border-gray-900 p-4">
                    <div class="flex items-center">
                        <div>
                            <div
                                class="h-9 w-9 rounded-full bg-gray-700 flex items-center justify-center text-gray-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-white">Guest User</p>
                            <p class="text-xs font-medium text-gray-500">Not connected</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Column -->
        <div class="flex-1 flex flex-col overflow-hidden bg-dark-bg">
            <!-- Mobile Header Stub (Simplified for mockup) -->
            <div class="md:hidden pl-1 pt-1 sm:pl-3 sm:pt-3 bg-gray-900 border-b border-gray-800 flex items-center">
                <div class="h-12 w-12 flex items-center justify-center">
                    <img src="{{ asset('assets/images/logo.png') }}" class="h-8 w-auto">
                </div>
                <span class="text-white font-bold ml-2">HashAlpha</span>
            </div>

            <!-- Scrollable Content -->
            <main class="flex-1 overflow-y-auto focus:outline-none">
                <div class="py-6">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">

                        <!-- Header -->
                        <div class="mb-8">
                            <h1 class="text-2xl font-bold text-white mb-2">My V-NFTs & Tokens</h1>
                            <p class="text-gray-400 text-sm">Manage your Validator NFTs and HASH token rewards.</p>
                        </div>

                        <!-- Top Grid: Wallet & Status -->
                        <div id="wallet-section" class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <!-- 1. Connectivity Card -->
                            <div class="bg-dark-card border border-gray-800 rounded-lg p-6 shadow-lg">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <h2 class="text-lg font-semibold text-white">Wallet Connection</h2>
                                        <p class="text-gray-400 text-sm mt-1">Connect your Web3 wallet to view your
                                            assets.</p>
                                    </div>
                                    <div class="p-2 bg-gray-900 rounded-lg">
                                        <svg class="h-6 w-6 text-gray-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>

                                <div class="mt-6">
                                    <div id="wallet-status-container">
                                        <button id="connect-wallet-btn" onclick="connectWallet()"
                                            class="w-full flex justify-center items-center px-4 py-3 border border-transparent text-sm font-medium rounded-md text-black bg-dark-accent hover:bg-cyan-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-dark-accent transition-colors">
                                            <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                            </svg>
                                            Connect Wallet
                                        </button>
                                        <p id="wallet-error" class="hidden mt-2 text-xs text-red-500 text-center"></p>
                                    </div>

                                    <!-- Connected State -->
                                    <div id="connected-state" class="hidden space-y-4">
                                        <div class="flex items-center justify-between bg-gray-900 px-3 py-2 rounded-md">
                                            <div class="flex items-center">
                                                <div class="h-2 w-2 bg-green-500 rounded-full mr-2 animate-pulse"></div>
                                                <span class="text-sm text-gray-300 font-mono"
                                                    id="wallet-address">0x...</span>
                                            </div>
                                            <button onclick="disconnectWallet()"
                                                class="text-xs text-red-400 hover:text-red-300">Disconnect</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 2. Status / Eligibility Card -->
                            <div
                                class="bg-dark-card border border-gray-800 rounded-lg p-6 shadow-lg relative overflow-hidden">
                                <!-- Background Glow -->
                                <div
                                    class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 bg-dark-accent opacity-5 rounded-full blur-2xl">
                                </div>

                                <h2 class="text-lg font-semibold text-white relative z-10">Eligibility Status</h2>

                                <!-- State: Waiting -->
                                <div id="status-waiting"
                                    class="h-40 flex flex-col items-center justify-center text-center relative z-10">
                                    <svg class="h-10 w-10 text-gray-700 mb-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                        </path>
                                    </svg>
                                    <p class="text-gray-500 text-sm">Please connect your wallet to check your V-NFT
                                        eligibility.</p>
                                </div>

                                <!-- State: Checking -->
                                <div id="status-checking"
                                    class="hidden h-40 flex flex-col items-center justify-center text-center relative z-10">
                                    <svg class="animate-spin h-8 w-8 text-dark-accent mb-3"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    <p class="text-gray-400 text-sm">Verifying blockchain history...</p>
                                </div>

                                <!-- State: Not Qualified -->
                                <div id="status-not-qualified" class="hidden h-full py-4 flex flex-col relative z-10">
                                    <div class="flex items-center mb-4">
                                        <span
                                            class="px-2 py-1 bg-yellow-900/30 text-yellow-500 text-xs font-bold rounded uppercase tracking-wider border border-yellow-900/50">
                                            Pre-Launch Phase
                                        </span>
                                    </div>
                                    <h3 class="text-xl font-bold text-white mb-2">Not Yet Qualified</h3>
                                    <p class="text-gray-400 text-sm mb-6 leading-relaxed">
                                        This wallet address is not currently on the V-NFT allowlist. Qualification is
                                        based on staking milestones and activity.
                                    </p>
                                    <div class="mt-auto">
                                        <div class="bg-dark-bg p-4 rounded-md border border-gray-800">
                                            <div class="flex">
                                                <div class="flex-shrink-0">
                                                    <svg class="h-5 w-5 text-dark-accent"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                                <div class="ml-3 flex-1 md:flex md:justify-between">
                                                    <p class="text-sm text-gray-300">New batches are processed weekly.
                                                    </p>
                                                    <p class="mt-2 text-sm md:mt-0 md:ml-6">
                                                        <a href="#"
                                                            class="whitespace-nowrap font-medium text-dark-accent hover:text-cyan-300">Learn
                                                            more &rarr;</a>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- State: Qualified (Hidden Prototype) -->
                                <div id="status-qualified" class="hidden h-full py-4 flex flex-col relative z-10">
                                    <div class="flex items-center mb-4">
                                        <span
                                            class="px-2 py-1 bg-green-900/30 text-green-500 text-xs font-bold rounded uppercase tracking-wider border border-green-900/50">
                                            Qualified
                                        </span>
                                    </div>
                                    <h3 class="text-xl font-bold text-white mb-2">You are Eligible!</h3>
                                    <p class="text-gray-400 text-sm mb-4">
                                        Your wallet has met the staking requirements for a <strong>Tier 1
                                            V-NFT</strong>.
                                    </p>
                                    <div class="mt-auto">
                                        <button
                                            class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded transition-colors shadow-lg shadow-green-900/20">
                                            Mint Badge
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- V-NFT Collection Grid -->
                        <div class="mt-8">
                            <h3 class="text-xl font-bold text-white mb-4">V-NFT Collection</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                                <!-- Tier 1 -->
                                <div
                                    class="bg-dark-card border border-gray-800 rounded-lg p-5 hover:border-gray-700 transition-colors group">
                                    <div
                                        class="aspect-square rounded-lg bg-black mb-4 flex items-center justify-center relative overflow-hidden shadow-2xl">
                                        <img src="{{ asset('assets/images/tier-bronze.png') }}" alt="Bronze Validator"
                                            class="object-cover w-full h-full transform hover:scale-105 transition-transform duration-700 ease-out">
                                        <div
                                            class="absolute inset-0 bg-black opacity-10 group-hover:opacity-0 transition-opacity">
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="text-white font-bold text-lg">Bronze Validator</h4>
                                            <p class="text-xs text-gray-500 uppercase tracking-wide mt-1">Tier 1</p>
                                        </div>
                                        <span
                                            class="px-2 py-1 bg-gray-800 text-gray-400 text-xs rounded border border-gray-700">Locked</span>
                                    </div>
                                    <div class="mt-4 pt-4 border-t border-gray-800">
                                        <div class="flex justify-between text-sm mb-1">
                                            <span class="text-gray-400">Requirement</span>
                                            <span class="text-white font-medium">$1,000 Staked</span>
                                        </div>
                                        <div class="w-full bg-gray-800 rounded-full h-1.5 mt-2">
                                            <div class="bg-orange-500 h-1.5 rounded-full" style="width: 25%"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tier 2 -->
                                <div
                                    class="bg-dark-card border border-gray-800 rounded-lg p-5 hover:border-gray-700 transition-colors group">
                                    <div
                                        class="aspect-square rounded-lg bg-black mb-4 flex items-center justify-center relative overflow-hidden shadow-2xl">
                                        <img src="{{ asset('assets/images/tier-silver.png') }}" alt="Silver Guardian"
                                            class="object-cover w-full h-full transform hover:scale-105 transition-transform duration-700 ease-out">
                                        <div
                                            class="absolute inset-0 bg-black opacity-10 group-hover:opacity-0 transition-opacity">
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="text-white font-bold text-lg">Silver Guardian</h4>
                                            <p class="text-xs text-gray-500 uppercase tracking-wide mt-1">Tier 2</p>
                                        </div>
                                        <span
                                            class="px-2 py-1 bg-gray-800 text-gray-400 text-xs rounded border border-gray-700">Locked</span>
                                    </div>
                                    <div class="mt-4 pt-4 border-t border-gray-800">
                                        <div class="flex justify-between text-sm mb-1">
                                            <span class="text-gray-400">Requirement</span>
                                            <span class="text-white font-medium">$10,000 Staked</span>
                                        </div>
                                        <div class="w-full bg-gray-800 rounded-full h-1.5 mt-2">
                                            <div class="bg-gray-600 h-1.5 rounded-full" style="width: 0%"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tier 3 -->
                                <div
                                    class="bg-dark-card border border-gray-800 rounded-lg p-5 hover:border-gray-700 transition-colors group">
                                    <div
                                        class="aspect-square rounded-lg bg-black mb-4 flex items-center justify-center relative overflow-hidden shadow-2xl">
                                        <img src="{{ asset('assets/images/tier-gold.png') }}" alt="Gold Sovereign"
                                            class="object-cover w-full h-full transform hover:scale-105 transition-transform duration-700 ease-out">
                                        <div
                                            class="absolute inset-0 bg-black opacity-10 group-hover:opacity-0 transition-opacity">
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="text-white font-bold text-lg">Gold Sovereign</h4>
                                            <p class="text-xs text-gray-500 uppercase tracking-wide mt-1">Tier 3</p>
                                        </div>
                                        <span
                                            class="px-2 py-1 bg-gray-800 text-gray-400 text-xs rounded border border-gray-700">Locked</span>
                                    </div>
                                    <div class="mt-4 pt-4 border-t border-gray-800">
                                        <div class="flex justify-between text-sm mb-1">
                                            <span class="text-gray-400">Requirement</span>
                                            <span class="text-white font-medium">$50,000 Staked</span>
                                        </div>
                                        <div class="w-full bg-gray-800 rounded-full h-1.5 mt-2">
                                            <div class="bg-yellow-600 h-1.5 rounded-full" style="width: 0%"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Info Footer -->
                        <div class="mt-8 bg-dark-card border border-gray-800 rounded-lg p-6">
                            <h3 class="text-lg font-medium text-white mb-4">About V-NFTs</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm text-gray-400">
                                <div>
                                    <h4 class="text-white font-medium mb-2">Proof of Validation</h4>
                                    <p>V-NFTs serve as on-chain proof of your contribution to the network security and
                                        validation efforts.</p>
                                </div>
                                <div>
                                    <h4 class="text-white font-medium mb-2">Dynamic Tiers</h4>
                                    <p>As your staking milestones grow, your NFT metadata updates automatically to
                                        reflect your new rank.</p>
                                </div>
                                <div>
                                    <h4 class="text-white font-medium mb-2">Exclusive Rewards</h4>
                                    <p>Holders gain access to exclusive governance voting rights and boosted yield
                                        farming pools.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection