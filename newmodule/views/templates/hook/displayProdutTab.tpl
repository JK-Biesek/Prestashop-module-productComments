
<h3 class="product-heading"  id="newmodulecomments-content-tab"{if isset($newmodule_posted)} data-scroll="true"
 {/if}>{l s='Product Comments' mod='newmodule'}</h3>
 {assign var=params value=['module_action'=>'list.tpl',
 'id_product'=>'$smarty.get.id_product']}
 <button class="btn btn-info" id="comments_toggle">Show comments</button>

<div class="rte">
 <br />
 <div id="show">
{foreach from=$comments item=comment}
  <img src="http://www.gravatar.com/avatar/   {$comment.email|trim|strtolower|md5}?s=45" class="pull-left img-thumbnail mymodcomments-avatar" />
  <p>{$comment.firstname} {$comment.lastname|substr:0:1}.</p>
  <p><strong class="abc">	 #{$comment.id_newmodule_comment}:</strong>
  {$comment.comment}<br>
  <strong class="abc">{l s='Grade' mod='newmodule'}:</strong>{$comment.grade}/5<br></p><br>{/foreach}
</div>

{if $enable_grades eq 1 OR $enable_comments eq 1}
<form action="" method="POST" id="comment-form">
{if $enable_grades eq 1}
<div class="form-group">

 <label for="grade">Grade:</label>

 <div class="row">
  <div class="col-xs-4">
   <select id="grade" class="form-control" name="grade">
   <option value="0">-- Choose --</option>
   <option value="1">1</option>
   <option value="2">2</option>
   <option value="3">3</option>
   <option value="4">4</option>
   <option value="5">5</option>
   </select>

  </div>
 </div>

</div>
{/if}
{if $enable_comments eq 1}
 <div class="form-group">
 <label for="comment">{l s='Comment' mod='newmodule'}:</label>
 <textarea name="comment" id="comment" class="form-control">
 </textarea>
 </div>
 <div class="form-group">  <label for="firstname">
    {l s='Firstname:' mod='mymodcomments'}  </label>

    <div class="row"><div class="col-xs-4">
       <input type="text" name="firstname" id="firstname" class="form-control" />
       </div></div>
       </div>

       <div class="form-group">
          <label for="lastname">
            {l s='Lastname:' mod='mymodcomments'}
        </label>
         <div class="row">
          <div class="col-xs-4">
            <input type="text" name="lastname" id="lastname" class="form-control" />
          </div></div>
         </div>

         <div class="form-group">
            <label for="email">
              {l s='Email:' mod='newmodule'}  </label>
              <div class="row"><div class="col-xs-4">
           <input type="email" name="email" id="email" class="form-control" />
           </div></div>
         </div>{/if}
 <div class="submit">
 <button type="submit" name="newmodule_pc_submit_comment"  class="button btn btn-default button-medium">
 <span>{l s='Send' mod='newmodule'}<i class="icon-chevron-right right">
 </i>
 </span>
 </button>
 </div>

</form>
{/if}
</div>
