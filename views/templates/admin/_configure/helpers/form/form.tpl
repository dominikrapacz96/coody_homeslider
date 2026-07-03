{extends file="helpers/form/form.tpl"}

{block name="field"}
  {if $input.type == 'file_lang'}
    <div class="col-lg-{if isset($input.col)}{$input.col|intval}{else}8{/if}{if !isset($input.label)} col-lg-offset-3{/if}">
      <div class="form-group">
        {foreach from=$languages item=language}
          {if $languages|count > 1}
            <div class="translatable-field lang-{$language.id_lang}" {if $language.id_lang != $defaultFormLanguage}style="display:none"{/if}>
          {/if}
            <div class="col-lg-{if $languages|count > 1}10{else}12{/if}">
              {if isset($fields[0]['form']['images'][$input.name][$language.id_lang]) && $fields[0]['form']['images'][$input.name][$language.id_lang]}
                <input type="hidden" name="{$input.name}_old_{$language.id_lang}" value="{$fields[0]['form']['images'][$input.name][$language.id_lang]|escape:'html':'UTF-8'}" />
                <p class="help-block">
                  <img src="{$image_baseurl}{$fields[0]['form']['images'][$input.name][$language.id_lang]|escape:'html':'UTF-8'}" alt="" class="img-thumbnail" style="max-width:200px;height:auto;" />
                </p>
              {/if}
              <div class="dummyfile input-group">
                <input id="{$input.name}_{$language.id_lang}" type="file" name="{$input.name}_{$language.id_lang}" class="hide-file-upload" accept="image/jpeg,image/png,image/gif,image/webp" />
                <span class="input-group-addon"><i class="icon-file"></i></span>
                <input id="{$input.name}_{$language.id_lang}-name" type="text" class="disabled" name="filename" readonly />
                <span class="input-group-btn">
                  <button id="{$input.name}_{$language.id_lang}-selectbutton" type="button" class="btn btn-default">
                    <i class="icon-folder-open"></i> {l s='Choose a file' d='Admin.Actions'}
                  </button>
                </span>
              </div>
            </div>
          {if $languages|count > 1}
            <div class="col-lg-2">
              <button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
                {$language.iso_code}
                <span class="caret"></span>
              </button>
              <ul class="dropdown-menu">
                {foreach from=$languages item=lang}
                  <li><a href="javascript:hideOtherLanguage({$lang.id_lang});" tabindex="-1">{$lang.name}</a></li>
                {/foreach}
              </ul>
            </div>
          {/if}
          {if $languages|count > 1}
            </div>
          {/if}
          <script>
            $(function () {
              $('#{$input.name}_{$language.id_lang}-selectbutton').on('click', function () {
                $('#{$input.name}_{$language.id_lang}').trigger('click');
              });
              $('#{$input.name}_{$language.id_lang}').on('change', function () {
                var val = $(this).val();
                var file = val.split(/[\\/]/);
                $('#{$input.name}_{$language.id_lang}-name').val(file[file.length - 1]);
              });
            });
          </script>
        {/foreach}
      </div>
      {if isset($input.desc) && $input.desc}
        <p class="help-block">{$input.desc}</p>
      {/if}
    </div>
  {else}
    {$smarty.block.parent}
  {/if}
{/block}
