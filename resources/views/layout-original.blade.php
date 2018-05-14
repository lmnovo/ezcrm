<html lang="en">
<head>
    <title>Styde.Net</title>

</head>
<body>

<nav class="navbar navbar-default container">
    <div class="container-fluid">
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{ url('lang', ['en']) }}">En</a></li>
                <li><a href="{{ url('lang', ['es']) }}">Es</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="jumbotron container">
    <p>{{ trans('crudbooster.name') }}</p>
</div>

</body>
</html>