                    <tr>
                      <td class="column-th">顯示 icon</td>
                      <td>
                        <input name="show_icon" type="checkbox" id="show_icon" value="1" <?php if ( $show_icon == 1) { echo "checked=\"checked\""; } ?>>
                        是，顯示
                        <?php if ( $mainitem == "m6" ){ ?>
                        <img src="../../images/p3/new.jpg" width="40" height="14" />
                        <?php } else { ?>
                        <img src="../../images/new.jpg" width="43" height="25" />
                        <?php } ?>
                      </td>
                    </tr>