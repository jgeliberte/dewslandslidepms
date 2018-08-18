
<?php if (!is_null($submetric_columns)): ?>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label" for="bulletin-checkbox">Accuracy Components</label>&ensp;<small>Check the inaccurate fields.</small>
		</div>
	</div>
	<?php for ($i = 0; $i < count($submetric_columns); $i += 1): ?>
		<?php $column = $submetric_columns[$i]; ?>
		<?php if ($i % 3 === 0): ?>
			<div class="row">
		<?php endif; ?>
				<div class="form-group col-sm-4">
					<label class="checkbox-inline"><input class="acc-checkbox" type="checkbox" name="<?php echo 'cbox[]'; //$column; ?>" value="<?php echo $column; ?>">
						<?php
							$labels = explode("_", $column);
							foreach ($labels as $word) {
								echo ucfirst($word) . " ";
							}
						?>
					</label>
				</div>
		<?php if ($i % 3 === 2 || $i === count($submetric_columns) - 1): ?>	
			</div>
		<?php endif; ?>
	<?php endfor; ?>
<?php endif; ?>
