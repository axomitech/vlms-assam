<!-- Display success message -->
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert" style="background-color: #d4edda; color: #155724;">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<!-- Display error messages -->
@if (session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert" style="background-color: #f8d7da; color: #721c24;">
    {{ session('error') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<!-- Display validation errors -->
@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert" style="background-color: #f8d7da; color: #721c24;">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<!-- Add a script to auto-hide the alert after 5 seconds -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        setTimeout(function () {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function (alert) {
                alert.classList.remove('show');
                alert.classList.add('fade');
            });
        }, 5000);
    });
</script>
