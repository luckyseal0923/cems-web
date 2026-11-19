                                <input name="Photo<?php echo $i?>" type="file" id="Photo<?php echo $i?>" <?php echo $file_tag_size;?> />
                                <?php
                                    if ( strLen(${'Photo'.$i}) > 4 ){
                                ?>
                                    ---
                                    [<a href="javascript:;" title="<?php echo ${'Photo'.$i};?>" onClick="JustSoPicWindow('<?php echo $uploadUrl1.${'Photo'.$i};?>','<?php echo ${'PhotoW'.$i};?>','<?php echo ${'PhotoH'.$i};?>','','','hug image','0');return document.MM_returnValue" class="red">預覽</a>]
                                    [<a href="javascript:;" class="red" onClick="if(confirm('<?php echo $warn_del1;?>')){location.href='<?php echo $_SERVER['PHP_SELF']."?nid=".$_SESSION["PKey_".$ModuleNo]."&file_id=".${'Photo'.$i.'_id'}."&s_ok=".$s_ok."&fm=".$fm.$search_go_str."&ppage=".$ppage;?>&motion=del&imgNo=1&act_type=pic';}else{return false;}">刪</a>]
                                <?php
                                        //顯示檔案位置
                                        if ( ${'Photo'.$i."HaveUrl"} == 1 ){
                                            echo $img_url.${'Photo'.$i};
                                        }
                                        
                                    } else {
                                        echo "[無圖]";	
                                    }
                                    
                                    //圖說
                                    if ( ${'Photo'.$i."HaveTxt"} == 1 ){
                                        echo "　圖說：<input name=\"PhotoM1\" type=\"text\" id=\"PhotoM1\" value=\"" . ${'PhotoM'.$i} . "\" " . $img_tag_size . " maxlength=\"255\">";
                                    }
                                    
                                    //顯示建議尺寸文字
                                    if ( ${'Photo'.$i."_Size"} != "" ){
                                        echo "<span class=\"red\">　" . ${'Photo'.$i."_Size"} . "</span>";
                                    }
                                ?>