					<?php
                        if ( $subitem == "aaa" ){
                            $new_str = "「新品上市」";
                        }
                    ?>
                    <tr>
                      <td class="column-th">最新產品顯示</td>
                      <td>
                      <input type="checkbox" name="show_new" id="show_new" value="1" <?php if ( $show_new == 1 ){ echo "checked=\"checked\""; } ?>>
                      是，最新產品顯示
                      </td>
                    </tr>