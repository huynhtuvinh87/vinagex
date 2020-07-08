<?=

$form->field($model, 'tag')->dropDownList($tag, ['id' => 'tags', 'multiple' => 'multiple'])->label(FALSE);
?>
<?=

$this->registerJs("
$('#tags').select2({
    tags: true,
    tokenSeparators: [',']
});
")?>