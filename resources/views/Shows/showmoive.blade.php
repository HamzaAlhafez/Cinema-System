@extends('layouts.layout')


@push('head')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush

@section('content')
 @include('dashboard.messages_alert')
    <section class="page-header overlay-gradient"
        style="background: url({{ asset('images/branding/posters/movie-collection.webp') }});">
        <div class="container">
            <div class="inner">
                <h2 class="title">Movies</h2>
                <ol class="breadcrumb">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li>Movies</li>
                </ol>
            </div>
        </div>
    </section>
     <main class="ptb100">
        <div class="container" x-data="{
            layout: 'grid',
            setLayout(newLayout) {
                if (newLayout != 'grid' && newLayout != 'list') return;
                this.layout = newLayout;
                localStorage.setItem('layout', newLayout);
            },
            init() {
                const localLayout = localStorage.layout;
                if (localLayout == 'grid' || localLayout == 'list') {
                    this.layout = localLayout;
                } else {
                    this.layout = 'grid';
                }
            }
        }">
         <!-- Start of Filters -->
            <div class="d-flex mb50 align-items-center justify-content-between">


                <form method="POST" action="{{route('showsmoive.Search')}}" class="d-flex">
                    @csrf

                    <input  name="textSearch" id="textSearch" class="py-1 form-control" placeholder="search.."
                        style="flex-basis: fit-content" value="" required>

                    <div class="px-3 py-3 py-xl-0"></div>

                     <div class="px-2 py-3 py-xl-0"></div>
                    <input type="submit" value="Search" class="btn btn-main">
                    


                   

                </form>
                <form method="GET" action="{{ route('shows.filterByCategory') }}" class="d-flex">
    @csrf

    <div class="d-flex align-items-center">
        <label for="category" class="pr-1 text-nowrap">Category:</label>
        <select name="category_id" id="category" class="py-1">
            <option value="">All Categories</option>
            @foreach (\App\Models\Categorie::all() as $category)
                <option value="{{ $category->id }}"
                    {{ request('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->title }}
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-purple ml-2">Filter</button>
</form>
            
             


               
                    


                   

                
                     <div class="py-3 py-xl-0"></div>
                       <div>
                        
                    <!-- Layout Switcher -->
                    <div class="layout-switcher">
                        <a href="#" class="list" x-bind:class="{ 'active': layout === 'list' }"
                            @@click.prevent="setLayout('list')">
                            <i class="fa fa-align-justify"></i>
                        </a>

                    </div>
                </div>


            </div>
            @if ($shows->isEmpty())
    <p class="bg-light font-weight-bold h4 p-5 rounded text-center">No Shows found!</p>
@else
    <!-- Start of Movie List -->
    <div class="row mt100" x-show="layout === 'list'" x-transition>
        @foreach ($shows as $show)
            @include('components.movie-list-item', ['show' => $show])
        @endforeach
    </div>
    <!-- End of Movie List -->
@endif
             


        </div>
    </main>
     @include('components.flash-message')

    <!-- =============== END OF MAIN =============== -->
@endsection