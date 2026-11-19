                    <tr>
                      <td class="column-th">首頁顯示</td>
                      <td>
                        <?php
                            if ( $subitem == "aaa" ){
                                $index_str = "「新品上市」";
                            }
                        ?>
                        <input name="show_index" type="checkbox" id="show_index" value="1" <?php if ( $show_index == 1) { echo "checked=\"checked\""; } ?>>
                        是，首頁<?php echo $index_str;?>顯示
                      </td>
                    </tr>