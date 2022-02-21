<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo $router->generate('main-home');   ?>">oShop</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                        <a class="nav-link" href="<?php echo $router->generate('user-list');   ?>">Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $router->generate('category-list');   ?>">Catégories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $router->generate('product-list');   ?>">Produits</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Types</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Marques</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Tags</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Sélections Accueil &amp; Footer</a>
                    </li>

                    <?php if(isset($_SESSION['userObject'])):?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $router->generate('user-logout');   ?>">Deconnexion</a>
                        </li>
                    <?php else : ?> 
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $router->generate('user-login');   ?>">Connexion</a>
                        </li>  
                        
                    <?php endif ?>
                </ul>
            </div>
        </div>
    </nav>