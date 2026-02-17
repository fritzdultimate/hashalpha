<div data-w-id="c1146e3a-416f-ff8e-14ce-0f478e33d7bf" data-animation="default" data-collapse="medium" data-duration="400" data-easing="ease" data-easing2="ease" role="banner" class="header-wrapper w-nav !halpha-fixed !halpha-bg-[#000] !halpha-z-[10000]  !halpha-top-0 !halpha-w-full" style="opacity: 1;">
    <div class="container-default w-container">
        <div class="header-content-wrapper">
            <div class="header-left-side">
                <a href="{{ route('home') }}" aria-current="page" class="header-logo-link w-nav-brand w--current">
                    <img src="{{ asset('img/logo/logo-white.png') }}" alt="Logo - {{ env('APP_NAME') }}" class="halpha-h-10 halpha-w-auto md:halpha-h-16 transition-transform duration-300 hover:scale-105">
                </a>
                <nav role="navigation" class="header-nav-menu-wrapper w-nav-menu">
                    <ul role="list" class="header-nav-menu-list">
                        <li class="header-nav-list-item">
                            <a href="{{ route('home') }}" aria-current="page" class="header-nav-link w-nav-link w--current" style="max-width: 1316px;">
                                Home
                            </a>
                        </li>
                        <li class="header-nav-list-item">
                            <a href="{{ route('about') }}" class="header-nav-link w-nav-link" style="max-width: 1316px;">
                                About
                            </a>
                        </li>
                        <li class="header-nav-list-item">
                            <a href="{{ route('staking') }}" class="header-nav-link w-nav-link" style="max-width: 1316px;">
                                Staking
                            </a>
                        </li>
                        <li class="header-nav-list-item">
                            <a href="{{ route('rewards') }}" class="header-nav-link w-nav-link" style="max-width: 1316px;">
                                Rewards
                            </a>
                        </li>
                        <li class="header-nav-list-item">
                            <a href="{{ route('nfts') }}" class="header-nav-link w-nav-link" style="max-width: 1316px;">
                                NFTs
                            </a>
                        </li>

                        <li class="header-nav-list-item">
                            <a href="{{ route('hash-token') }}" class="header-nav-link w-nav-link" style="max-width: 1316px;">
                                $Hash Token
                            </a>
                        </li>
                        <li class="header-nav-list-item">
                            <div data-hover="true" data-delay="0" data-w-id="c1146e3a-416f-ff8e-14ce-0f478e33d7d1" class="dropdown-wrapper w-dropdown" style="max-width: 1316px;">
                                <div class="dropdown-toggle w-dropdown-toggle" id="w-dropdown-toggle-0" aria-controls="w-dropdown-list-0" aria-haspopup="menu" aria-expanded="false" role="button" tabindex="0">
                                    <div>Explore</div>
                                    <div class="line-rounded-icon dropdown-arrow" style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg, 0deg); transform-style: preserve-3d;">
                                        
                                    </div>
                                </div>
                                <nav class="dropdown-column-wrapper w-dropdown-list" id="w-dropdown-list-0" aria-labelledby="w-dropdown-toggle-0" style="display: none; height: 0px; opacity: 0; transform: translate3d(0px, 10px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg, 0deg); transform-style: preserve-3d;">
                                    <div class="dropdown-column-grid-container">
                                        <div class="w-layout-grid grid-2-columns dropdown-main-grid">
                                            <div>
                                                <div class="text-200 dropdown-column-title">Exploring</div>
                                                <div class="grid-3-columns dropdown-main-pages-grid">
                                                    <div class="w-layout-grid grid-1-column dropdown-link-column">
                                                        <a href="{{ route('affiliate.index') }}" class="dropdown-link w-dropdown-link" tabindex="0">
                                                            Affliate Program
                                                        </a>
                                                        <a href="{{ route('resources.index') }}" class="dropdown-link w-dropdown-link" tabindex="0">
                                                            Resources
                                                        </a>
                                                        <a href="{{ route('support.index') }}" class="dropdown-link w-dropdown-link" tabindex="0">
                                                            Support
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </nav>
                            </div>
                        </li>
                        <li class="header-nav-list-item show-on-tablet">
                            <div class="btn-primary-wrapper">
                                <a href="{{ route('login') }}" class="btn-primary small w-button">Login</a>
                                <div class="btn-primary-border"></div>
                            </div>
                        </li>
                    </ul>
                    <div class="divider nav-menu-bottom-divider---tablet"></div>
                </nav>
            </div>
            
            <div class="header-right-side">
                <!-- Social medial links -->
                <div class="social-media-links-container hidden-on-mbl">
                    <a href="https://www.t.me/hashalphaofficial" target="_blank" class="social-link-single w-inline-block">
                        <x-ri-telegram-2-fill />
                    </a>

                    <a href="https://www.youtube.com/@hashalphaglobal" target="_blank" class="social-link-single w-inline-block">
                        <x-ri-youtube-fill />
                    </a>
                </div>
                
                <div class="btn-primary-wrapper hidden-on-tablet">
                    <a href="{{ route('login') }}" class="btn-primary small w-button">Login</a>
                    <div class="btn-primary-border"></div>
                </div>
                
                <!-- Mobile menu toggler -->
                <div class="hamburger-menu-wrapper w-nav-button" style="-webkit-user-select: text;" aria-label="menu" role="button" tabindex="0" aria-controls="w-nav-overlay-0" aria-haspopup="menu" aria-expanded="false">
                    <div class="hamburger-menu-bar top" style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg, 0deg); transform-style: preserve-3d;"></div>
                    <div class="hamburger-menu-bar bottom" style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg, 0deg); transform-style: preserve-3d;"></div>
                </div>
            </div>
        </div>
        <div class="divider mg-0"></div>
    </div>
    <div class="w-nav-overlay" data-wf-ignore="" id="w-nav-overlay-0"></div>
</div>