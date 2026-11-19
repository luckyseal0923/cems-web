                    <tr>
                        <td valign="top" class="column-th"><?php echo $t_show_date;?><i class="fa fa-asterisk"></i></td>
                        <td>
                        <script>
                        function setCheckedValue(radioObj, newValue) {
                            if(!radioObj)
                                return;
                            var radioLength = radioObj.length;
                            if(radioLength == undefined) {
                                radioObj.checked = (radioObj.value == newValue.toString());
                                return;
                            }
                            for(var i = 0; i < radioLength; i++) {
                                radioObj[i].checked = false;
                                if(radioObj[i].value == newValue.toString()) {
                                    radioObj[i].checked = true;
                                }
                            }
                        }
                        </script>
                        <input name="NoOpenDate" type="radio" id="NoOpenDate" class="m-input" value="0" <?php if ( strLen($OpenDate) == 0 ){ echo "checked=\"checked\""; } ?> />馬上刊登
                        <input name="NoOpenDate" type="radio" id="NoOpenDate" class="m-input" value="1" <?php if ( strLen($OpenDate) > 0 ) { echo "checked=\"checked\""; } ?> />
                        <input name="OpenDate" type="text" id="OpenDate" class="m-input" value="<?php echo $OpenDate;?>" size="10" readonly="readonly" style="width:110px;" />
                        <a href="javascript:;" onclick="setCheckedValue(document.forms['form1'].elements['NoOpenDate'], '1');"><img src="../images/img.gif" name="BTN1" width="20" height="14" border="0" align="absmiddle" id="BTN1" style="cursor: pointer; border: 1px solid red;" title="Date selector" onmouseover="this.style.background='red';"  onmouseout="this.style.background=''" /></a>
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
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="column-th">
                        <?php
                            if ( $subitem == "aaa" ){
                                echo $t_removed_data2;
                            } else {
                                echo $t_removed_data;
                            }
                        ?><i class="fa fa-asterisk"></i>
                        </td>
                        <td>
                        <input name="NoEndDate" type="radio" id="NoEndDate" class="m-input" value="0" <?php if ( $NoEndDate != 1 ){ echo "checked=\"checked\""; } ?> />永不下架
                        <input name="NoEndDate" type="radio" id="NoEndDate" class="m-input" value="1" <?php if ( $NoEndDate == 1 ){ echo "checked=\"checked\""; } ?> />
                        <input name="EndDate" type="text" id="EndDate" class="m-input" value="<?php echo $EndDate;?>" size="10" readonly="readonly" style="width:110px;" />
                        <a href="javascript:;" onclick="setCheckedValue(document.forms['form1'].elements['NoEndDate'], '1');"><img src="../images/img.gif" name="BTN2" width="20" height="14" border="0" align="absmiddle" id="BTN2" style="cursor: pointer; border: 1px solid red;" title="Date selector" onmouseover="this.style.background='red';" onmouseout="this.style.background=''" /></a>
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