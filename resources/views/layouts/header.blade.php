@php
        $hour = \Carbon\Carbon::now()->format('H');
        if ($hour < 12) {
            $greeting = 'Good Morning';
            $icon = 'bx bxs-sun'; // Morning sun icon
        } elseif ($hour < 18) {
            $greeting = 'Good Afternoon';
            $icon = 'fas fa-cloud-sun'; // Afternoon icon with sun and cloud
        } else {
            $greeting = 'Good Evening';
            $icon = 'bx bxs-moon'; // Evening moon icon
        }
    @endphp
    <div class="row">
        <div class="col-md-6 mb-2">
            <h6><i class='{{ $icon }}'></i>
                {{ $greeting }} {{ Auth::user()->name }}</h6>
        </div>
        <div class="col-md-6 text-right">
            <h6> <i class='bx bxs-calendar'></i> Today is {{ \Carbon\Carbon::now()->format('j F Y (l)') }}</h6>
        </div>
    </div>