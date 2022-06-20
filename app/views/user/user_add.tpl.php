<div class="container my-4">
        <a href=<?=$router->generate('user-list') ?> class="btn btn-success float-end">Retour</a>
        <h2>Ajouter un utilisateur</h2>
        
        <form action="<?= $router->generate('user-create')  ?>" method="POST" class="mt-5">

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Email de l'utilisateur">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Mot de passe utilisateur">
            </div>
            <div class="mb-3">
                <label for="password_confirm" class="form-label">Mot de passe confirmation</label>
                <input type="password" name="password_confirm" class="form-control" id="password_confirm" placeholder="Mot de passe utilisateur">
            </div>
            <div class="mb-3">
                <label for="firstname" class="form-label">Nom</label>
                <input type="text" name="firstname" class="form-control" id="firstname" placeholder="Nom de l'utilisateur">
            </div>
            <div class="mb-3">
                <label for="lastname" class="form-label">Prénom</label>
                <input type="text" name="lastname" class="form-control" id="lastname" placeholder="Prénom utilisateur">
            </div>
            <div class="form-group">
                <label for="role">Rôle</label>
                <select class="form-select" name="role" id="role" aria-describedby="typeHelpBlock">
                    
                    <option value="1">catalog-manager</option>
                    <option value="2">admin</option>
                </select>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-select" name="status" id="status" aria-describedby="typeHelpBlock">
                    
                    <option value="0">-</option>
                    <option value="1">actif</option>
                    <option value="2">désactivé</option>
                </select>
            </div>
            
            <input type="hidden" class="form-control" name="token" id="token" value="<?= $_SESSION['token']; ?>" >
                        

        <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary mt-5">Valider</button>
        </div>

        </form>

        
        
    </div>