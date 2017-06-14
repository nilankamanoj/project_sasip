<h2 class="form-signin-heading">Offer Free Card</h2><hr />

<div class="form-group">
<li><font color =#ooooff size=4>Name :</font><?php print($row['first_name']);print("  ");print($row['last_name'])?></li>
<li><font color =#ooooff size=4>Id number:</font><?php print($row['identity_no']); ?></li>
<li><font color =#ooooff size=4>School:</font><?php print($row['school_name']); ?></li>

<div class="clearfix"></div><hr />
<div class="form-group">
<button  type="submit" class="btn btn-primary" name="btn-confirm">
<i class="glyphicon glyphicon-open-file"></i>&nbsp;Offer free card
</button>
<button  type="submit" background-color=#ffff00 name="btn-another">
<i class=""></i>&nbsp;Search Again
</button>
</div>
<br />
