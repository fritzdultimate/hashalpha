@extends('layouts.guest')

@section('content')

    <section class="top-section halpha-py-16 md:halpha-py-32">
        <div class="w-layout-blockcontainer container-default z-index-1 w-container">
            <div class="text-center mg-bottom-40px !halpha-flex halpha-flex-col halpha-gap-6">
                <div data-w-id="a4708a42-280d-b422-b575-8ac43cd058e5" style="opacity: 1; filter: blur(0px);"
                    class="inner-container _764px center">
                    <h1 class="halpha-text-4xl sm:halpha-text-5xl md:halpha-text-7xl halpha-font-semibold heading-color-gradient mg-bottom-0">Founded with a mission to simplify blockchain participation.</h1>
                </div>
                <div data-w-id="c16957c9-54cf-1436-610a-b7a81345da1f" style="opacity: 1; filter: blur(0px);"
                    class="inner-container _694px center halpha-text-gray-400">
                    <p>We specialize in validator node operations, decentralized staking pools, and yield optimization through MEV-boosted infrastructure. Our goal is to make institutional-grade blockchain earning opportunities accessible to individuals and communities across the globe.</p>
                </div>
            </div>
            <div data-w-id="5efe5cb4-a493-305f-011b-7f8e173d14a6" style="opacity: 1; filter: blur(0px);"
                class="buttons-flex-container center">
                <div data-w-id="5efe5cb4-a493-305f-011b-7f8e173d14a7" class="btn-primary-wrapper">
                    <a href="{{ route('register') }}"
                        class="btn-primary w-button">
                        Get started
                        <span class="line-rounded-icon link-icon-right"></span>
                    </a>
                    <div class="btn-primary-border"></div>
                </div>
                <a href="{{ route('staking') }}" class="btn-secondary w-button">Learn more</a>
            </div>
        </div>
    </section>


    @include('components.guest.core-concepts')
    @include('components.guest.vission-and-mission')
    @include('components.guest.why-us')



    @include('components.guest.team')



@endsection