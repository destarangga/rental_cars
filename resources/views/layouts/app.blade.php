<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/content.css') }}">
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo-details">
                <div class="logo_name">Rental</div>
                <i class='bx bx-menu' id="btn" ></i>
            </div>
            <ul class="nav-list">
                <li>
                    <a href="{{ route('dashboard') }}">
                        <i class='bx bx-home-alt'></i>
                        <span class="links_name">Home</span>
                    </a>
                    <span class="tooltip">Home</span>
                </li>
                <li>
                    <a href="{{ route('cars.index') }}">
                        <i class='bx bx-box'></i>
                        <span class="links_name">Cars</span>
                    </a>
                    <span class="tooltip">cars</span>
                </li>
                <li>
                    <a href="{{ route('rentals.index') }}">
                        <i class='bx bx-food-menu'></i>
                        <span class="links_name">Rental</span>
                    </a>
                    <span class="tooltip">Rental</span>
                </li>
                @if (auth()->check())
                <li class="profile">
                    <div class="profile-details">
                        <div class="name">
                            <div class="name">{{ auth()->user()->name }}</div>
                            <div class="job">{{ auth()->user()->role }}</div>
                        </div>
                    </div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button>
                            <i class='bx bx-log-out' id="log_out"></i>
                        </button>
                    </form>
                </li>
                @endif
            </ul>
        </div>

        <!-- Main Content -->
        <div class="container">
            @yield('content') 
        </div>
    </div>

    <script>
      let sidebar = document.querySelector(".sidebar");
      let closeBtn = document.querySelector("#btn");
      let searchBtn = document.querySelector(".bx-search");
    
      closeBtn.addEventListener("click", ()=> {
        sidebar.classList.toggle("open");
        menuBtnChange(); 
      });
    
      searchBtn.addEventListener("click", ()=> { 
        sidebar.classList.toggle("open");
        menuBtnChange();
      });
    
      function menuBtnChange() {
        if(sidebar.classList.contains("open")) {
          closeBtn.classList.replace("bx-menu", "bx-menu-alt-right"); 
        } else {
          closeBtn.classList.replace("bx-menu-alt-right", "bx-menu"); 
        }
      }
    </script>
     <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-ZVP8gziD15h9NUX7YgPfH+6m3uZQ4LkD3mDP5PBjGMq0PzBr64Vf8uY44S0N1Q0t" crossorigin="anonymous"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-5c5ss5x56t/6UbR5I76sKDf8G9bNnE8+RW2nbQ+fxZBgBv1Ke5sZ9M2qeHeD4F8g" crossorigin="anonymous"></script>
</body>
</html>
