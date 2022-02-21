<div class="container my-4">
        
        <h2>Connexion</h2>
        
        <form action="<?= $router->generate('main-connexionValidate')  ?>" method="POST" class="mt-5">

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" name="email" class="form-control" id="email" placeholder="Email">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="text" name="password" class="form-control" id="password" placeholder="Password" aria-describedby="subtitleHelpBlock">
                
            </div>                      

        <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary mt-5">Valider</button>
        </div>

        </form>

        
        
    </div>