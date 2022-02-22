<div class="container my-4">
        
        <h2>Connexion</h2>
        
        <form action="<?= $router->generate('user-connect')  ?>" method="POST" class="mt-5">

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Email">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Password" aria-describedby="subtitleHelpBlock">
                
            </div>                      
            <input type="hidden" class="form-control" name="token" id="token" value="<?= $_SESSION['token']; ?>" >
        <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary mt-5">Se connecter</button>
        </div>

        </form>

        
        
    </div>