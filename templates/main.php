<?php
namespace be\mch\tpnf;

defined('BE_MCH_TPNF')||die();
?>
<section id="this-page-needs-files">
	<input type="hidden" name="tpnf-indices"/>
	<table>
    	<thead>
        	<tr>
            	<th>
                	Action
                </th>
                <th>
                	ID
                </th>
                <th>
                	Relative
                </th>                
                <th>
                	File
                </th>
                <th>
                	Priority
                </th>
                <th>
                	Type
                </th>
            </tr>
        </thead>
    	<tbody>
        	<?php
			foreach($model->Urls->Urls as $aUrl):
			?>
        	<tr>
            	<td>
                	<a class="tpnf-delete submitdelete deletion" href="javascript:void(0);" tabindex="-1" >delete</a>
                </td>
            	<td>
                	<input type="text" class="tpnf-id" value="<?php echo($aUrl->ID); ?>" placeholder="ID attribute" />
                    <span></span>
                </td>
                <td>
                    <select class="tpnf-relative">
						<?php
                        foreach($model->Relatives as $aRelative):
                        ?>
                    	<optgroup label="<?php echo($aRelative->Label); ?>">
	                    	<option value="<?php echo($aRelative->Relative); ?>" <?php echo($aRelative->Relative == $aUrl->Relative ? "selected" : ""); ?>><?php echo($aRelative->Name); ?></option>
                        </optgroup>
						<?php
						endforeach;
						?> 
                    </select>
                </td>                   
            	<td>
                	<input type="text" class="tpnf-fileName" value="<?php echo($aUrl->File); ?>"  placeholder="URL to file" />
                    <span></span>
                </td>
            	<td>
                	<input type="text" class="tpnf-priority" value="<?php echo($aUrl->Priority); ?>"  placeholder="Priority"
                    	pattern="^((b(ottom)?)|(t(op)?))?\s*((\+|-|(^\s*))\s*(1000|[0-9]{1,3}))?$"
                     />
                    <span></span>
                </td>
                
                <td>
                	<select class="tpnf-type">
                    	<option value="auto" <?php echo($aUrl->IDEAuto ? "selected" : ""); ?>>Auto</option>
                    	<option value="js" <?php echo((!$aUrl->IDEAuto && $aUrl->Type == TPNF_Model_Url_EType::Js) ? "selected" : ""); ?>>Javascript</option>
                    	<option value="css" <?php echo((!$aUrl->IDEAuto && $aUrl->Type == TPNF_Model_Url_EType::Css) ? "selected" : ""); ?>>CSS</option>                        
                    </select>
                </td>
            </tr>
            <?php
			endforeach;
			?>
        </tbody>
    </table>
</section>
