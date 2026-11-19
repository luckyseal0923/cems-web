                       <tr>
                          <td><?php echo $t_show_date ?>：</td>
                          <td>
                            <input name="OpenDate" type="text" id="OpenDate" size="10"  value="<?php echo $OpenDate ?>" readonly="readonly" onclick="this.value='';" />
                            <img src="images/img.gif" alt="<?php echo $pageTitle."-"?>上架日期" width="20" height="14" align="absmiddle" id="BTN1" style="cursor: pointer; border: 1px solid red;" title="Date selector" onmouseover="this.style.background='red';" onmouseout="this.style.background=''" />
                            <script type="text/javascript">
                            Calendar.setup({
                                inputField     :    "OpenDate",  //input元件主題
                                ifFormat       :    "%Y/%m/%d",　//輸出日期格式
                                showsTime      :    false, //日曆是否要在底訲顯示時間
                                button         :    "BTN1", //啟動日曆的按鈕id
                                singleClick    :    true, //是否需要雙擊按鈕才能啟動
                                steo           :    1 //上一年及次一年,年份間格,預設2
                            });
                             </script>
                              　
                              <?php echo $t_removed_data ?>：
                            <input name="EndDate" type="text" id="EndDate" size="10"  value="<?php echo $EndDate ?>" readonly="readonly" onclick="this.value='';" />
                            <img src="images/img.gif" alt="<?php echo $pageTitle."-"?>上架日期" width="20" height="14" align="absmiddle" id="BTN2" style="cursor: pointer; border: 1px solid red;" title="Date selector" onmouseover="this.style.background='red';" onmouseout="this.style.background=''" />
                            <script type="text/javascript">
                            Calendar.setup({
                                inputField     :    "EndDate",  //input元件主題
                                ifFormat       :    "%Y/%m/%d",　//輸出日期格式
                                showsTime      :    false, //日曆是否要在底訲顯示時間
                                button         :    "BTN2", //啟動日曆的按鈕id
                                singleClick    :    true, //是否需要雙擊按鈕才能啟動
                                steo           :    1 //上一年及次一年,年份間格,預設2
                            });
                            </script>
                          </td>
                       </tr>