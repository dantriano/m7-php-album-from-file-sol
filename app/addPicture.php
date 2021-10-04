<?php include_once('_header.php') ?>
<div class="card">
    <div class="card-body">
        <form action="uploadManager.php" method="post" enctype="multipart/form-data">
            <h2>Upload Picure</h2>
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" class="form-control">
            <label for="picture">Picture:</label>
            <input type="file" name="picture" id="picture" class="form-control">
            <div class="col-auto mt-3">
            <button type="submit" class="btn btn-primary">Upload</button>
            </div>
        </form>
    </div>
</div>
<?php include_once('_footer.php') ?>