<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

    <div>
        <label for="input-file">Specify a file:</label><br>
        <input type="file" id="input-file">
    </div>

    <textarea id="content-target" class="form-control" style="min-height: 300px"></textarea>
</div>
<?php ob_start(); ?>
<script type="text/javascript">
    document.getElementById('input-file')
            .addEventListener('change', getFile)

    function getFile(event) {
        const input = event.target
        if ('files' in input && input.files.length > 0) {
            placeFileContent(
                    document.getElementById('content-target'),
                    input.files[0])
        }
    }

    function placeFileContent(target, file) {
        readFileContent(file).then(content => {
            target.value = content
        }).catch(error => console.log(error))
    }

    function readFileContent(file) {
        const reader = new FileReader()
        return new Promise((resolve, reject) => {
            reader.onload = event => resolve(event.target.result)
            reader.onerror = error => reject(error)
            reader.readAsText(file)
        })
    }
</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>