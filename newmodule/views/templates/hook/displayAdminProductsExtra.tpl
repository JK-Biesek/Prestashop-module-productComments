<div class=" product-tab-content" id="product-tab-content-mymodcomments" style="display: block;">
	<div class="panel product-tab" id="product-mymodcomments">
		<h3 class="tab"> <i class="icon-info"></i> {l s='Product Comments' mod='newmodule'}</h3>

		<table style="width:100%">
			<thead>
			<tr>
				<th>{l s='ID' mod='newmodule'}</th>
				<th>{l s='Author' mod='newmodule'}</th>
				<th>{l s='E-mail' mod='newmodule'}</th>
				<th>{l s='Grade' mod='newmodule'}</th>
				<th>{l s='Comment' mod='newmodule'}</th>
				<th>{l s='Date' mod='newmodule'}</th>
			</tr>
			</thead>
			<tbody>
            {foreach from=$comments item=comment}
			<tr>
				<td>#{$comment.id_newmodule_comment}</td>
				<td>{$comment.firstname} {$comment.lastname}</td>
				<td>{$comment.email}</td>
				<td>{$comment.grade}/5</td>
				<td>{$comment.comment}</td>
				<td>{$comment.date_add}</td>
			</tr>
            {/foreach}
			</tbody>
</table>
</div>
</div>
