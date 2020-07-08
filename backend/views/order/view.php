<?php 
  use common\components\Constant;
 ?>
<div class="container">
  <h2>Đơn hàng: # <b><?= $model->code ?></b></h2>
  <p>Đặt ngày: <b><?= date('d/m/Y - H:i:s', $model->created_at)?></b></p>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Sản phẩm</th>
        <th>Số lượng</th>
        <th>Đơn gía</th>
        <th>Tổng cộng</th>
      </tr>
    </thead>
    <tbody>
      <?php 
      $total = 0;
      foreach ($model->product as $key => $value) { 
        $total += $value['quantity'] * $value['price'];
      ?>
        <tr>
          <td><img src="<?= Yii::$app->setting->get('siteurl_cdn') ?>/image.php?src=<?= $value['image'] ?>&size=60x60" style="border-radius: 4px; float: left; margin-right: 10px"><a target="_blank" href="<?= Yii::$app->setting->get('siteurl').'/'.$value['slug'].'-'.$value['id'] ?>"><?= $value['title'] . (($value['type'] != 0) ? " loại " . $value['type'] : "") ?></a></td>
          <td><?= $value['quantity'] . ' ' . $value['unit'] ?></td>
          <td><?= Constant::price($value['price']).' đ' ?></td>
          <td><?= Constant::price($value['price']*$value['quantity']).' đ' ?></td>
        </tr>

      <?php } ?>

      <tr>
        <td colspan="3"><b>Tổng tiền: </b></td>
        <td><h4><?= Constant::price($total) ?></h4></td>
      </tr>

    </tbody>
  </table>

  <?php if($model->status != Constant::STATUS_ORDER_PENDING && $model->status != Constant::STATUS_ORDER_BLOCK){ ?>
    <p>Ngày giao hàng: <b><?= date('d/m/Y - H:i:s', $model->date_begin)?></b></p>
    <p>Ngày dự kiến giao hàng thành công: <b><?= date('d/m/Y - H:i:s', $model->date_end)?></b></p> 
    <?php if(!empty($model->transport)){ ?>
    <p style="margin: 0">Thông tin người giao hàng:</p>
    <div class="form-group">
      <textarea class="form-control" rows="2" readonly><?= $model->transport ?></textarea>
    </div> 
  <?php } ?>
  <?php } ?>
  <?php if($model->status == Constant::STATUS_ORDER_FINISH){ ?>
      <p><i><?= !empty($model->getReviewBuyer()['description'])?'"'.$model->getReviewBuyer()['description'].'"':"" ?></i> <small>(<?= Constant::REVIEW_BUYER[$model->getReviewBuyer()['level_satisfaction']] ?>)</small> - <b><a target="_blank" href="<?= Yii::$app->setting->get('siteurl').'/nha-vuon/'.$model->getReviewBuyer()['owner']['username'] ?>"><?= $model->getReviewBuyer()['owner']['garden_name'] ?></a></b></p>
  <?php } ?>
</div>