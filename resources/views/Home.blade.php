@extends('layout.plantilla')
@section('title', 'Home')
@section('content')
    <section class="hero-section d-flex align-items-center">
        <div class="section-title-div container">
            <div class="row">
                <div class="section-title-items col-lg-6">
                    <h1 class="section-title unique-font">ZRT MOMO TIRES ARG</h1>
                    <p>Lorem ipsum dolor sit amet consectetur adipiscing elit. Quis soluta commodi blanditiis hic.
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Culpa accusantium perspiciatis laudantium
                        pariatur. Reiciendis fugiat doloribus voluptate enim accusamus beatae delectus eius ullam, explicabo
                        vitae, corrupti odit. Magnam, architecto iste?
                        Nobis eos molestias, error quo rerum, iure ex obcaecati dolores suscipit minus dignissimos.
                        Laudantium quisquam blanditiis velit ad repellat neque expt.
                    </p>
                    <img src="{{ asset('img\LOGONACHOSINFONDO 1.svg') }}" alt="Momo Tires Logo " class="hero-img">
                </div>
                <div class="section-title-img col-lg-6">
                    <img src="{{ asset('img\coche 1.svg') }}" alt="Auto en pista" class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    <!-- Sección Características -->
    <section class="features-section d-flex align-items-center">
        <div>
            <h2 class="section-title">CARACTERÍSTICAS</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quis soluta commodi blanditiis hic, laborum quo
                delectus, non molestiae magni quas ea! Perferendis repudiandae perspiciatis atque architecto.</p>
        </div>
    </section>

    <!-- Sección Únete -->
    <section class="join-section d-flex align-items-center">
        <div>
            <h2 class="section-title">ÚNETE</h2>
            <p>DISCORD</p>
            <p>

                <svg class="svg-discord" version="1.1" viewBox="0 0 2048 2048" width="100" height="100"
                    xmlns="http://www.w3.org/2000/svg">
                    <path transform="translate(991)"
                        d="m0 0h66l52 3 47 5 46 7 45 9 52 13 43 13 40 14 40 16 27 12 34 16 27 14 23 13 29 17 23 15 21 14 17 12 19 14 18 14 22 18 14 12 11 10 8 7 13 12 8 8 8 7 14 14 7 8 11 11 7 8 11 12 9 11 9 10 20 25 15 20 13 18 14 20 13 20 13 21 13 22 16 29 17 33 15 33 12 28 13 34 12 34 13 43 13 52 8 40 7 44 5 43 3 41 1 23v64l-2 39-4 44-5 38-7 41-9 42-10 39-11 36-12 36-13 34-13 31-13 28-14 29-12 22-11 20-17 28-15 24-13 19-12 17-14 19-22 28-22 26-10 11-7 8-12 13-9 9-7 8-13 13-8 7-11 11-8 7-12 11-11 9-10 9-25 20-20 15-18 13-20 14-20 13-21 13-22 13-29 16-33 17-33 15-28 12-39 15-36 12-29 9-42 11-41 9-33 6-42 6-40 4-29 2-22 1h-66l-38-2-44-4-38-5-41-7-42-9-39-10-36-11-36-12-34-13-31-13-28-13-29-14-22-12-20-11-28-17-24-15-19-13-17-12-19-14-28-22-14-12-11-9-12-11-8-7-13-12-9-9-8-7-13-13-7-8-11-11-7-8-11-12-9-11-9-10-20-25-15-20-13-18-14-20-13-20-13-21-13-22-16-29-17-33-15-33-12-28-13-34-12-34-13-43-13-52-8-40-7-44-5-43-3-41-1-22v-66l2-38 4-44 5-38 7-41 9-42 10-39 11-36 12-36 13-34 13-31 13-28 14-29 15-28 14-24 12-20 14-22 13-19 12-17 14-19 14-18 18-22 12-14 10-11 7-8 12-13 9-9 7-8 13-13 8-7 11-11 8-7 12-11 11-9 10-9 25-20 20-15 18-13 20-14 17-11 19-12 27-16 29-16 33-17 33-15 28-12 34-13 34-12 43-13 52-13 40-8 44-7 43-5 41-3z"
                        fill="#5763F2" />
                    <path transform="translate(841,541)"
                        d="m0 0h5l12 22 17 35 4 10 13-1 34-4 37-3 19-1h87l46 3 45 5 12 1 12-26 12-25 9-16 11 1 45 9 52 13 36 11 36 12 32 12 29 12 23 10 6 7 11 17 16 25 19 32 13 23 15 28 15 30 16 36 11 26 14 37 12 35 12 41 11 44 9 44 7 45 5 44 3 43 1 25v59l-2 44-3 37-2 6-15 11-16 11-15 10-22 14-28 17-25 14-25 13-17 9-28 13-37 16-39 15-47 16-9 2-10-13-22-33-17-28-16-29-4-9 32-13 24-11 30-15 21-12h2v-2l-4-2-13-10-9-7-23 10-30 12-34 12-33 10-44 11-43 8-39 5-39 3h-76l-39-3-38-5-34-6-31-7-34-9-35-11-35-13-31-13-7-3-5 1-16 13-6 4-1 2 5 2 29 16 22 11 32 14 20 8-2 6-14 26-17 28-10 16-13 19-12 17-9-2-36-12-38-14-36-15-39-18-28-14-22-12-28-16-26-16-42-28-17-12-4-3-3-35-2-41v-73l3-52 4-39 7-49 8-42 10-42 11-40 14-43 13-35 14-34 13-29 16-33 10-20 12-22 16-28 14-23 14-22 16-24 24-11 42-17 36-13 41-13 45-12 40-9z"
                        fill="#FEFEFE" />
                    <path transform="translate(1230,945)"
                        d="m0 0h16l14 2 17 5 16 8 13 9 12 11 8 9 10 15 9 19 6 21 2 14v29l-3 18-6 20-8 17-8 12-9 11-11 11-14 10-16 8-16 5-11 2h-26l-18-4-15-6-14-8-10-8-10-9-10-12-8-13-7-14-6-18-3-14-1-8v-28l3-18 5-17 7-16 10-16 12-14 11-10 15-10 16-7 19-5z"
                        fill="#5763F2" />
                    <path transform="translate(805,945)"
                        d="m0 0h16l19 3 19 7 11 6 11 8 10 9 7 7 11 15 8 15 6 16 4 17 1 7v34l-3 17-5 17-10 21-10 14-9 10-8 8-14 10-16 8-16 5-11 2h-25l-15-3-15-5-18-10-11-9-14-14-10-14-9-17-7-21-3-15-1-10v-19l3-22 6-20 8-17 10-15 11-12 9-9 15-10 17-8 14-4z"
                        fill="#5763F2" />
                    <path transform="translate(1481,637)"
                        d="m0 0 6 2 7 9 15 23 12 19 16 27 13 23 14 26 19 38 16 36 15 37 13 36 13 40 12 44 9 40 8 43 6 43 4 39 2 29 1 22v73l-2 40-3 36-3 5-18 13-39 26-21 13-22 13-18 10-26 14-30 15-36 16-34 14-44 16-31 10-4-1-11-15v-3l40-13 35-13 29-12 27-12 34-16 27-14 23-13 29-17 23-15 16-10 14-10 17-12 4-3 2-16 3-44 1-26v-59l-2-43-4-45-6-45-7-40-10-45-10-38-13-42-13-37-16-40-16-36-16-33-15-29-13-23-17-29-12-19-13-20z"
                        fill="#574FF2" />
                    <path transform="translate(1348,1325)"
                        d="m0 0 6 4 15 12 6 4v2l-5-1-3-2-6 1-20 9-33 13-28 10-37 11-40 10-37 7-35 5-31 3-42 2h-30l-42-2-39-4-38-6-39-8-31-8-36-11-29-10-30-12-23-10-5 1-12 10-5 4-6-2-17-10 2-4 11-8 11-9 7 1 25 11 37 14 36 12 37 10 30 7 32 6 36 5 32 3 16 1h76l39-3 39-5 43-8 48-12 38-12 33-12 31-13z"
                        fill="#574FF2" />
                    <path transform="translate(1230,945)"
                        d="m0 0h16l14 2 17 5 16 8 13 9 12 11 2 4-14-8-13-6-12-4-21-3h-10l-21 3-15 5-17 9-12 9-7 6-7 8-10 14-9 17-7 21-3 14-1 9v24l3 20 5 16 5 12 8 15 5 8-4-2-7-7-10-13-10-17-8-21-4-18-1-8v-28l3-18 5-17 7-16 10-16 12-14 11-10 15-10 16-7 19-5z"
                        fill="#574FF2" />
                    <path transform="translate(805,945)"
                        d="m0 0h16l19 3 19 7 11 6 11 8 10 9 5 5-1 2-8-6-16-8-15-5-10-2-11-1h-9l-17 2-17 5-16 8-11 7-13 12-9 10-9 14-8 16-6 19-3 16-1 11v14l2 18 5 20 9 21 9 14-1 2-12-12-10-14-9-17-7-21-3-15-1-10v-19l3-22 6-20 8-17 10-15 11-12 9-9 15-10 17-8 14-4z"
                        fill="#574FF2" />
                    <path transform="translate(408,1361)"
                        d="m0 0 5 2 38 25 21 13 29 17 24 13 27 14 27 13 32 14 30 12 30 11 45 15 2-4 13-19 16-24 17-28 13-24 4-4 20 8-2 6-15 28-17 28-12 19-14 20-8 11-10-2-50-17-38-15-28-12-28-13-38-19-46-26-26-16-27-18-19-13-15-11z"
                        fill="#574FF2" />
                    <path transform="translate(859,558)" d="m0 0 5 1 15 29 9 19-3 2h-6l-7-15-16-33v-2z" fill="#5750F2" />
                </svg>
            </p>
        </div>
    </section>



@endsection