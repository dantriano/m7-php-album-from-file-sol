<?php
include_once('_header.php');
include('Class/GalleryClass.php');
$gallery = new Gallery("pictures/list.txt");
?>
<div class="row">
    <?
    foreach ($gallery->getGallery() as $picture) {
    ?>
        <div class="col-lg-4 col-md-12 mb-4 mb-lg-0">
            <img src="<?= $picture->fileName() ?>" class="w-100 shadow-1-strong rounded" alt="">
            <figcaption class="figure-caption"><?= $picture->title() ?></figcaption>
        </div>
    <? } ?>
    <?php
    if (sizeof($gallery->getGallery()) == 0) { ?>
        <div class="alert alert-primary" role="alert">
            The gallery is empty
        </div>
    <?php
    }
    ?>
</div>
<?php include_once('_footer.php') ?>