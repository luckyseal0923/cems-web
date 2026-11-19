					   <tr>
					     <td class="column-th">更新日期</td>
					     <td>
						<?php
							if ( $_SESSION["PKey_".$ModuleNo] != "" ) {
								
								if ( $subitem == "m100" ){
								//預約單
									echo Date_EN($dtUDate,1)." -- ".$UserID;
									
								} else {
									echo Date_EN($dtUDate,1)." -- ".$UserID2;
								}
								
							} else {
								echo date("Y/m/d")." -- ".$_SESSION["Login_ID"];
							}
                        ?>
                         </td>
					   </tr>