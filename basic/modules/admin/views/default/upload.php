<?php
use yii\widgets\ActiveForm;
?>
<?php if($model->image): ?>
    <img width="189" height="255" src="http://kappa.cs.petrsu.ru/~iermolae/web2/lab5/basic1/basic/web/uploads/<?= $model->image?>" alt="">
<?php endif; ?>

<?php $form = ActiveForm::begin() ?>
<?= $form->field($model, 'image')->fileInput() ?>
<button>Upload</button>


<?php ActiveForm::end() ?>

