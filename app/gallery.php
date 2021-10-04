<?php
include_once('_header.php');
include('Class/PictureClass.php');
define("PICTURES_LIST", "pictures/list.txt");

$gallery = loadGallery();

function loadGallery()
{
    $gallery = [];
    if (file_exists(PICTURES_LIST)) {
        $file = fopen(PICTURES_LIST, "r");
        while (!feof($file)) {
            $line = fgets($file);
            $pic_info = explode("###", $line);
            if ($pic_info[0] && $pic_info[1]) {
                $picture = new Picture($pic_info[0], $pic_info[1]);
                array_push($gallery, $picture);
            }
        }
        fclose($file);
    }
    return $gallery;
}
?>
<div class="row">
    <?
    foreach ($gallery as $picture) {
    ?>
        <div class="col-lg-4 col-md-12 mb-4 mb-lg-0">
            <img src="<?= $picture->fileName() ?>" class="w-100 shadow-1-strong rounded" alt="">
            <figcaption class="figure-caption"><?= $picture->title() ?></figcaption>
        </div>
    <? } ?>
    <?php
    if (sizeof($gallery) == 0) { ?>
        <div class="alert alert-primary" role="alert">
            The gallery is empty
        </div>
    <?php
    }
    ?>
</div>
<?php include_once('_footer.php') ?>