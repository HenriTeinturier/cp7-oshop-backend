<div class="container my-4">
        <a href="<?=$router->generate('product-list') ?>" class="btn btn-success float-end">Retour</a>
        <h2>Modifier un produit</h2>
        
        <form action="" method="POST" class="mt-5">
            <!-- Choix du nom -->
            <div class="mb-3">
                <label for="name" class="form-label">Nom</label>
                <input type="text" name="name" class="form-control" value="<?= $product->getName()?>" id="name" placeholder="Nom de la catégorie">
            </div>
            <!-- choix description -->
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" placeholder="descriptions" aria-describedby="descriptionHelpBlock"><?= $product->getDescription()?>
                </textarea>
            </div>
            <!-- choix Image -->
            <div class="mb-3">
                <label for="picture" class="form-label">Image</label>
                <input type="text" name="picture" class="form-control" id="picture" placeholder="image jpg, gif, svg, png" value="<?= $product->getPicture()?>" aria-describedby="pictureHelpBlock">
                <small id="pictureHelpBlock" class="form-text text-muted">
                    URL relative d'une image (jpg, gif, svg ou png) fournie sur <a href="https://benoclock.github.io/S06-images/" target="_blank">cette page</a>
                </small>
            </div>
            <!-- choix tarif  -->
            <div class="mb-3">
                <label for="price" class="form-label">Tarif</label>
                <input type="text"value="<?= $product->getPrice()?>" name="price" class="form-control" id="price" placeholder="exemple 40.00" aria-describedby="subtitleHelpBlock">  
            </div>          
            
            <!-- choix de la catégorie -->
            <div class="form-group">
                <label for="categorie">Categorie</label>
                <select class="form-select" name="category_id" id="categorie" aria-describedby="typeHelpBlock">
                    <?php foreach($categories as $category)   :?>
                    <option value="<?php echo $category->getId()?>"
                        <?php echo ($category->getId()== $product->getCategoryId())? 'selected' :'' ?>><?=$category->getName();?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <!-- choix de la marque -->
            <div class="form-group">
                <label for="brand">Marque</label>
                <select class="form-select" name="brand_id" id="brand" aria-describedby="typeHelpBlock">
                    <?php foreach($brands as $brand)   :?>
                    <option value="<?=$brand->getId();?>" 
                    <?php echo ($brand->getId() == $product->getBrandId())? 'selected' : ''   ?>
                    ><?=$brand->getName();?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <!-- choix du type -->
            <div class="form-group">
                <label for="type">Type</label>
                <select class="form-select" name="type_id" id="type" aria-describedby="typeHelpBlock">
                    <?php foreach($types as $type)   :?>
                    <option value="<?=$type->getId();?>"
                    <?php echo ($type->getId() == $product->getTypeId())? 'selected' : ''   ?>
                    ><?=$type->getName();?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <?php if ($validate):  ?>
                <div class="alert alert-success" role="alert">
                Modification validée
                </div>
            <?php endif ?>           
            <input type="hidden" class="form-control" name="token" id="token" value="<?= $_SESSION['token']; ?>" >
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary mt-5">Valider</button>
            </div>
        </form>
    </div>