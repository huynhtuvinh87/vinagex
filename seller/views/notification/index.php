<?php 
use yii\widgets\ListView;
 ?>
 	<?php if ($dataProvider->totalCount > 0) { ?>
 		<a id="check-read-all" href="/notification/checkall">Đánh dấu tất cả là đã xem</a>
 	<?php } ?>
	<div class="content-notification">
			<ul class="list-item">
				<?=
                ListView::widget([
                    'dataProvider' => $dataProvider,
                    'emptyText' => 'Chưa có thông báo nào.',
                    'layout' => "{items}\n<div class='row'><div class='col-sm-12 pagination-page'>{pager}</div></div>",
                    'itemView' => '/notification/_item',
                ]);
                ?>
			</ul>
	</div>

<?php ob_start(); ?>
<script>
        $('.read').click(function(){
        	var id = $(this).data('id');
        	var url = $(this).data('href');
        	$.ajax({
	            url: '<?= Yii::$app->urlManager->createUrl(["notification/status"]); ?>',
	            type: 'POST',
	            data: 'id='+id,
	            success: function (data) {
	            	$(location).attr('href', url);
	         	}
	        });
        });

        $('.check-read').click(function(){
        	var id = $(this).data('id');
        	var count = parseInt($('#notification span').text());

        	$.ajax({
	            url: '<?= Yii::$app->urlManager->createUrl(["notification/checkread"]); ?>',
	            type: 'POST',
	            data: 'id='+id,
	            success: function (data) {
	            	if(data == 0){
	            		$("#item-"+id).removeClass("active");
	            		$("#item-"+id).addClass("noactive");
	            		$('#notification span').html(count+1);
	            		if(isNaN(count)){
	            			$("#notification").append("<span>1<span>");
	            		}
	            		$("#item-"+id+" .check-read").attr('title','Đánh dấu đã đọc');
	            	}else{
	            		$("#item-"+id).removeClass("noactive");
	            		$("#item-"+id).addClass("active");
	            		$('#notification span').html(count-1);
	            		if(count-1 == 0){
	            			$('#notification span').remove();
	            		}
	            		$("#item-"+id+" .check-read").attr('title','Đánh dấu chưa đọc');
	            	}
	            	return false;
	         	}
	        });
        });

        $('#check-read-all').click(function() {
            return confirm('Bạn có muốn đánh dấu đã xem hết?');
        });

</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>