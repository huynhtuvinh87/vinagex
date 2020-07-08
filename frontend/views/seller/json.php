<?php 

	use yii\bootstrap\ActiveForm;
 ?>

 	<?php 
 		foreach ($list as $key => $value) { ?>
 			<?php if(empty($value['ward'])){ ?>
	 			<div id="<?= $value['_id'] ?>">
	 			<a href=""><?php echo $value['_id'].' -- '.$value['name']; ?></a> -- ID GIT <input id="git-<?= $value['_id'] ?>" type="text">--<input type="button" class="btn btn-success ok" value="submit" data-id="<?= $value['_id'] ?>"><br><br>
	 			</div>
 		<?php } ?>
 		<?php	
 		}
 	 ?>

<?php ob_start(); ?>
   <script>
       $(".ok").click(function(){
		    id = $(this).attr('data-id');
		    idGit = $('#git-'+id).val();

		    $.ajax({
            url: '<?= Yii::$app->urlManager->createUrl(["seller/json"]); ?>',
            type: 'post',
            data: 'idDistrict=' + id + '&idGit=' + idGit,
            success: function (data) {
                 $('#'+id).hide();
            }
        });
		});
   </script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>