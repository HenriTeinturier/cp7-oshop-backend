<form action="<?php echo $router->generate('main-homepagevalid')  ?>"   method="POST" class="mt-5 essai">
    
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="emplacement1">Emplacement #1</label>
                <select class="form-control" id="emplacement1" name="emplacement[]">
                    <?php foreach($categories as $categorie) :  ?>
                    
                    <option value="<?= $categorie->getId();?>" 
                    
                    <?php echo $categorie->getHomeOrder() == 1? "selected" : "";  ?>
                    
                    ><?= $categorie->getName(); ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="emplacement2">Emplacement #2</label>
                <select class="form-control" id="emplacement2" name="emplacement[]">
                <?php foreach($categories as $categorie) :  ?>
                    
                    <option value="<?= $categorie->getId();?>" 
                    
                    <?php echo $categorie->getHomeOrder() == 2? "selected" : "";  ?>
                    
                    ><?= $categorie->getName(); ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="emplacement3">Emplacement #3</label>
                <select class="form-control" id="emplacement3" name="emplacement[]">
                <?php foreach($categories as $categorie) :  ?>
                    
                    <option value="<?= $categorie->getId();?>" 
                    
                    <?php echo $categorie->getHomeOrder() == 3? "selected" : "";  ?>
                    
                    ><?= $categorie->getName(); ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="emplacement4">Emplacement #4</label>
                <select class="form-control" id="emplacement4" name="emplacement[]">
                <?php foreach($categories as $categorie) :  ?>
                    
                    <option value="<?= $categorie->getId();?>" 
                    
                    <?php echo $categorie->getHomeOrder() == 4? "selected" : "";  ?>
                    
                    ><?= $categorie->getName(); ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="emplacement5">Emplacement #5</label>
                <select class="form-control" id="emplacement5" name="emplacement[]">
                <?php foreach($categories as $categorie) :  ?>
                    
                    <option value="<?= $categorie->getId();?>" 
                    
                    <?php echo $categorie->getHomeOrder() == 5? "selected" : "";  ?>
                    
                    ><?= $categorie->getName(); ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
    </div>
                         
        <script src=<?php echo './../app.js' ?>></script>
      
    <input type="hidden" class="form-control" name="token" id="token" value="<?= $_SESSION['token']; ?>" >

    <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
</form>