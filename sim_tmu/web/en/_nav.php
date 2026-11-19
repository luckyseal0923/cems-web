

<?php if ( $pageName=="p1" ) { ?>
<div class="container_menu2"> <a class="toggleMenu2 color_1" href="#">【
  <?php echo $p1;?>
  】<span><i class="fa fa-caret-down"></i></span></a>
  <div class="menu_scrool2">
    <ul class="nav_list2">
    <?php
			$KIND = SqlFilter($_REQUEST["KIND"],"tab");
			
            /***取得分類清單***/
			if ( $KIND == "" ){
	            $SQL = "Select PKey, Class1_PKey, strName_c,showIndex From ".$dbName."_class Where intLang = 2 and Class1_PKey = ".SqlFilter($Class1_PKey,"int")." And Upload = 'Yes' And showIndex<>1 Order By Sort";
			}else{
				//$subReq = "&KIND=7";
				$SQL = "Select PKey, Class1_PKey, strName_c,showIndex From ".$dbName."_class Where intLang = 2 and Class1_PKey = ".SqlFilter($Class1_PKey,"int")." And Upload = 'Yes' And showIndex=1 Order By Sort";				
			}
            $rs1 = new recordset($SQL);
            while (! $rs1->eof ){
				
				$LINK = "";
				$num1 = "";
				$subReq = "";
				
				if ( $rs1->field("showIndex") == 1 ){ $subReq = "&KIND=7";}
				
				/***取得資料筆數***/
				//$SQL = "Select * From $dbName Where intLang = 2 and Class1_PKey = ".SqlFilter($Class1_PKey,"int")." And Class2_PKey = ".SqlFilter($Class2_PKey,"int");
				$SQL = "Select * From $dbName Where intLang = 2 and Class1_PKey = ".SqlFilter($rs1->field("Class1_PKey"),"int")." And Class2_PKey = ".SqlFilter($rs1->field("PKey"),"int");
				$result = mysql_query($SQL);
				$num1 = mysql_num_rows($result);

				/*判斷顯示型態*/
				$SQL = "Select * From $dbName Where intLang = 2 and Class1_PKey = ".SqlFilter($Class1_PKey,"int")." And Class2_PKey = ".SqlFilter($rs1->field("PKey"),"int")." Order By Sort";
				$rsD = new recordset($SQL);
	?>
                  
                <li class="<?php if ( strval($Class2_PKey) == strval($rs1->field("PKey")) ) { ?>on<?php } ?>">
                <?php
					/***判斷是否顯示次類別***/
		            if ( $num1 >= 2 ){
						echo "<a href=\"#\">".$rs1->field("strName_c")."<i class=\"fa fa-caret-down\"></i>";
					}else{
						echo "<a href=\"page_detail.php?Class1_PKey=".$Class1_PKey."&Class2_PKey=".$rs1->field("PKey").$subReq."\">".$rs1->field("strName_c");
					}
				?>
                  	 </a>
                <?php if ( $num1 >= 2 ){?>
                  <ul>
					<?php
                            /*取得次類別(標題)資料*/
                            $SQL  = " Select * From $dbName Where intLang = 2 and Class1_PKey = ".SqlFilter($Class1_PKey,"int"). " And Class2_PKey = ".SqlFilter($rs1->field("PKey"),"int")." And";
                            $SQL .= " Upload = 'Yes' Order By Sort";
                            $rs11 = new recordset($SQL);
                            while (! $rs11->eof ){
                    ?>
                            <li class="<?php if ( strval($PKey) == strval($rs11->field("PKey")) ) { ?>on<?php } ?>"> <a href="page_detail.php?Class1_PKey=<? echo $rs11->field("Class1_PKey")?>&Class2_PKey=<? echo $rs11->field("Class2_PKey")?>&PKey=<? echo $rs11->field("PKey").$subReq?>">
                              <? echo $rs11->field("strName_c") ?>
                              </a> </li>
					<?php
                                $rs11->movenext();
                            }
                    ?>
                  </ul>
                <?php }?>
                </li>
    <?php
                $rs1->movenext();
            }
	?>
    </ul>
  </div>
</div>



<?php } elseif( $pageName=="p2" ){ ?>
<div class="container_menu2"> <a class="toggleMenu2 color_3" href="#">【
  <?php echo $p2;?>
  】<span><i class="fa fa-caret-down"></i></span></a>
  <div class="menu_scrool2">
    <ul class="nav_list2">
    
    
        <?php
            /***取得分類清單***/
            $SQL = "Select PKey, Class1_PKey, strName_c From ".$dbName."_class Where intLang = 2 and Class1_PKey = ".SqlFilter($Class1_PKey,"int")." And Upload = 'Yes' Order By Sort";
            $rs1 = new recordset($SQL);
            while (! $rs1->eof ){			
				
				/*判斷顯示型態*/
				$SQL = "Select * From $dbName Where intLang = 2 and Class1_PKey = ".SqlFilter($Class1_PKey,"int")." And Class2_PKey = ".SqlFilter($rs1->field("PKey"),"int")." Order By Sort";
				$rsD = new recordset($SQL);
				if (! $rsD->eof ){
					
					/***取得資料筆數***/
					$SQL = "Select * From $dbName Where intLang = 2 and Class1_PKey = ".SqlFilter($Class1_PKey,"int")." And Class2_PKey = ".SqlFilter($rs1->field("PKey"),"int");
					$result = mysql_query($SQL);
					$num2 = mysql_num_rows($result);
					
					if ( $rsD->field("showType") == 1 ){
						if ( $num2 == 1 ){
							/*判斷是否為外部網址*/
							if ( preg_match("/www/",$rsD->field("strName2")) == true || preg_match("/WWW/",$rsD->field("strName2")) == true ){
								$LINK = "http://".$rsD->field("strName2");
								$LINK1 = " target='_blank'";
							}else{
								if ( preg_match("/cid/",$rsD->field("strName2")) == true ){
									$LINK = $rsD->field("strName2")."&Class1_PKey=".SqlFilter($rsD->field("Class1_PKey"),"int")."&Class2_PKey=".SqlFilter($rsD->field("Class2_PKey"),"int")."&PKey=".SqlFilter($rsD->field("PKey"),"int");
								}else{
									$LINK = $rsD->field("strName2")."?Class1_PKey=".SqlFilter($rsD->field("Class1_PKey"),"int")."&Class2_PKey=".SqlFilter($rsD->field("Class2_PKey"),"int")."&PKey=".SqlFilter($rsD->field("PKey"),"int");
								}
							}
						}else{
							$LINK = "page_detail.php?Class1_PKey=".$Class1_PKey."&Class2_PKey=".SqlFilter($rs1->field("PKey"),"int")."&PKey=".$rsD->field("PKey");	
						}
					}else{
						$LINK = "page_detail.php?Class1_PKey=".$Class1_PKey."&Class2_PKey=".SqlFilter($rs1->field("PKey"),"int")."&PKey=".$rsD->field("PKey");
					}
				}
				
  	 				
		?>
    
                <li class="<?php if ( strval($Class2_PKey) == strval($rs1->field("PKey")) ) { ?>on<?php } ?>">
                <?php
					/***判斷是否顯示次類別***/
		            if ( $num2 >= 2 || $rs1->field("PKey") == 8 || $rs1->field("PKey") == 9 ){
						echo "123";
						exit;
						echo "<a href=\"#\">".$rs1->field("strName_c")."<i class=\"fa fa-caret-down\"></i>";
					}else{
						echo "456";
						exit;
						echo "<a href=".$LINK.">".$rs1->field("strName_c");
					}
				?>
                </a>
                <?php if ( $num2 >= 2 || $rs1->field("PKey") == 8 || $rs1->field("PKey") == 9 ){?>
                  <ul>
                  <?php if ( $rs1->field("PKey") == 8 || $rs1->field("PKey") == 9 ){
					  echo "****";
					  exit;
					  
							if ( $rs1->field("PKey") == 8 ){ 
								$cid = 1;
								echo $cid;
								exit;
								$SQL_T  = " select ";
								$SQL_T .= " T.* ";
								$SQL_T .= " from p_dbClass2 as T ";
								$SQL_T .= " left join p_dbClass1 as C on T.Class1_PKey = C.PKey ";
								$SQL_T .= " where 1=1 ";
								$SQL_T .= " and C." . $this_LNG . " = 1 ";
								$SQL_T .= " and C.upordown = 1 ";
								$SQL_T .= " and T." . $this_LNG . " = 1 ";
								$SQL_T .= " and T.upordown = 1 ";
								$SQL_T .= " and T.PKey <> 1 ";
								$SQL_T .= " and T.Class1_PKey = 1";
								$SQL_T .= $order_t;
								$rsT = new recordset($SQL_T);
								//echo "SQL_T=" . $SQL_T . "<br>";
								$curT = 1;
							}else{
								$cid = 2;
								echo $cid;
								exit;
								$SQL_T  = " select ";
								$SQL_T .= " T.* ";
								$SQL_T .= " from p_dbClass2 as T ";
								$SQL_T .= " left join p_dbClass1 as C on T.Class1_PKey = C.PKey ";
								$SQL_T .= " where 1=1 ";
								$SQL_T .= " and C." . $this_LNG . " = 1 ";
								$SQL_T .= " and C.upordown = 1 ";
								$SQL_T .= " and T." . $this_LNG . " = 1 ";
								$SQL_T .= " and T.upordown = 1 ";
								$SQL_T .= " and T.PKey <> 1 ";
								$SQL_T .= " and T.Class1_PKey = 2";
								$SQL_T .= $order_t;
								$rsT = new recordset($SQL_T);
								//echo "SQL_T=" . $SQL_T . "<br>";
								$curT = 1;
							}
				  }
        
						while ( !$rsT->eof ){
		
							$top_t_strName = "";
							if ( $this_LNG == "language_c" ){
								$top_t_strName = $rsT->field("strName_c");
							}
		
							$top_t_link_url = "";
							$top_t_link_url = "href=\"p2_video2.php?cid=" . $cid . "&tid=" . $rsT->field("PKey") . "&Class1_PKey=" . $Class1_PKey . "&Class2_PKey=" .SqlFilter($rs1->field("PKey"),"int") . "\"";
                  ?>
                            <li class="<?php if ( $tid == $rsT->field("PKey") ) { ?>on<?php } ?>"> 
                            <a <?php echo $top_t_link_url;?>>
                              <?php echo $top_t_strName;?>
                              </a> </li>
					<?php
                                $rsT->movenext();
                                $curT = $curT + 1;
                                }//while
                    ?>
                  
                  
                  
                  <?php }else{?>
					<?php
                            /*取得次類別(標題)資料*/
                            $SQL  = " Select * From $dbName Where intLang = 2 and Class1_PKey = ".SqlFilter($Class1_PKey,"int"). " And Class2_PKey = ".SqlFilter($rs1->field("PKey"),"int")." And";
                            $SQL .= " Upload = 'Yes' Order By Sort";
                            $rs11 = new recordset($SQL);
                            while (! $rs11->eof ){
								$LINK1="";
								if ( $rs11->field("showType") == 1 ){
									/*判斷是否為外部網址*/
									if ( preg_match("/www/",$rs11->field("strName2")) == true || preg_match("/WWW/",$rs11->field("strName2")) == true ){
										$LINK = "http://".$rs11->field("strName2");
										$LINK1 = " target='_blank'";
									}else{
										$LINK = $rs11->field("strName2")."?Class1_PKey=".$Class1_PKey."&Class2_PKey=".SqlFilter($rs11->field("Class2_PKey"),"int")."&PKey=".$rs11->field("PKey");
									}
								}else{
									$LINK = "page_detail.php?Class1_PKey=".$Class1_PKey."&Class2_PKey=".SqlFilter($rs11->field("Class2_PKey"),"int")."&PKey=".$rs11->field("PKey");
								}
								
                    ?>
                            <li class="<?php if ( strval($PKey) == strval($rs11->field("PKey")) ) { ?>on<?php } ?>"> <a href="<? echo $LINK?>" <? echo $LINK1?>>
                              <? echo $rs11->field("strName_c") ?>
                              </a> </li>
					<?php
                                $rs11->movenext();
                            }
                    ?>
                  <?php }?>
                    
                    
                    
                    
                    
                    
                    
                    
                  </ul>
                <?php }?>
                </li>
        
        
        <?php
        		$rs1->movenext();
			}		
		?>        
        
    </ul>
  </div>
</div>






<?php } elseif( $pageName=="p3" ){ ?>

<div class="container_menu2"> <a class="toggleMenu2 color_4" href="#">【
  <?php echo $p3;?>
  】<span><i class="fa fa-caret-down"></i></span></a>
  <div class="menu_scrool2">
    <ul class="nav_list2">
		<?php
            /***取得分類清單***/
            $SQL = "Select PKey, Class1_PKey, strName_c From ".$dbName."_class Where intLang = 2 and Class1_PKey = ".SqlFilter($Class1_PKey,"int")." And Upload = 'Yes' Order By Sort";
            $rs1 = new recordset($SQL);
            while (! $rs1->eof ){
				
				$LINK = "";
				
				/*判斷顯示型態*/
				$SQL = "Select * From $dbName Where intLang = 2 and Class1_PKey = ".SqlFilter($Class1_PKey,"int")." And Class2_PKey = ".SqlFilter($rs1->field("PKey"),"int")." Order By Sort";
				$rsD = new recordset($SQL);
				if (! $rsD->eof ){
					
					/***取得資料筆數***/
					$SQL = "Select * From $dbName Where intLang = 2 and Class1_PKey = ".SqlFilter($Class1_PKey,"int")." And Class2_PKey = ".SqlFilter($rs1->field("PKey"),"int");
					$result = mysql_query($SQL);
					$num2 = mysql_num_rows($result);
					
					if ( $rsD->field("showType") == 1 ){
						if ( $num2 == 1 ){
							/*判斷是否為外部網址*/
							if ( preg_match("/www/",$rsD->field("strName2")) == true || preg_match("/WWW/",$rsD->field("strName2")) == true ){
								$LINK = "http://".$rsD->field("strName2");
								$LINK1 = " target='_blank'";
							}else{
								$LINK = $rsD->field("strName2")."?Class1_PKey=".$Class1_PKey."&Class2_PKey=".SqlFilter($rs1->field("PKey"),"int")."&PKey=".$rsD->field("PKey");
							}
						}else{
							$LINK = "page_detail.php?Class1_PKey=".$Class1_PKey."&Class2_PKey=".SqlFilter($rs1->field("PKey"),"int")."&PKey=".$rsD->field("PKey");	
						}
					}else{
						$LINK = "page_detail.php?Class1_PKey=".$Class1_PKey."&Class2_PKey=".SqlFilter($rs1->field("PKey"),"int")."&PKey=".$rsD->field("PKey");
					}
				}
        ?>
        
        
                <li class="<?php if ( strval($Class2_PKey) == strval($rs1->field("PKey")) ) { ?>on<?php } ?>">
                <?php
					/***判斷是否顯示次類別***/
		            if ( $num2 >= 2 ){
						echo "<a href=\"#\">".$rs1->field("strName_c")."<i class=\"fa fa-caret-down\"></i>";
					}else{
						echo "<a href=\"page_detail.php?Class1_PKey=".$Class1_PKey."&Class2_PKey=".$rs1->field("PKey").$subReq."\">".$rs1->field("strName_c");
					}
				?>
                  	 </a>
                <?php if ( $num2 >= 2 ){?>
                  <ul>
					<?php
                            /*取得次類別(標題)資料*/
                            $SQL  = " Select * From $dbName Where intLang = 2 and Class1_PKey = ".SqlFilter($Class1_PKey,"int"). " And Class2_PKey = ".SqlFilter($rs1->field("PKey"),"int")." And";
                            $SQL .= " Upload = 'Yes' Order By Sort";
                            $rs11 = new recordset($SQL);
                            while (! $rs11->eof ){
                    ?>
                            <li class="<?php if ( strval($PKey) == strval($rs11->field("PKey")) ) { ?>on<?php } ?>"> <a href="page_detail.php?Class1_PKey=<? echo $rs11->field("Class1_PKey")?>&Class2_PKey=<? echo $rs11->field("Class2_PKey")?>&PKey=<? echo $rs11->field("PKey").$subReq?>">
                              <? echo $rs11->field("strName_c") ?>
                              </a> </li>
					<?php
                                $rs11->movenext();
                            }
                    ?>
                  </ul>
                <?php }?>
                </li>
		<?php
                    $rs1->movenext();
                }
        ?>
    </ul>
  </div>
</div>




<?php } elseif( $pageName=="p4" ){ ?>
<div class="container_menu2"> <a class="toggleMenu2 color_5" href="#">【
  <?php echo $p4;?>
  】<span><i class="fa fa-caret-down"></i></span></a>
  <div class="menu_scrool2">
    <ul class="nav_list2">
		<?php
            /***取得分類清單***/
            $SQL = "Select PKey, Class1_PKey, strName_c From ".$dbName."_class Where intLang = 2 and Class1_PKey = ".SqlFilter($Class1_PKey,"int")." And Upload = 'Yes' Order By Sort";
            $rs1 = new recordset($SQL);
            while (! $rs1->eof ){
				
				$LINK = "";
				
				/*判斷顯示型態*/
				$SQL = "Select * From $dbName Where intLang = 2 and Class1_PKey = ".SqlFilter($Class1_PKey,"int")." And Class2_PKey = ".SqlFilter($rs1->field("PKey"),"int")." Order By Sort";
				$rsD = new recordset($SQL);
				if (! $rsD->eof ){
					
					/***取得資料筆數***/
					$SQL = "Select * From $dbName Where intLang = 2 and Class1_PKey = ".SqlFilter($Class1_PKey,"int")." And Class2_PKey = ".SqlFilter($rs1->field("PKey"),"int");
					$result = mysql_query($SQL);
					$num2 = mysql_num_rows($result);
					
					if ( $rsD->field("showType") == 1 ){
						if ( $num2 == 1 ){
							/*判斷是否為外部網址*/
							if ( preg_match("/www/",$rsD->field("strName2")) == true || preg_match("/WWW/",$rsD->field("strName2")) == true ){
								$LINK = "http://".$rsD->field("strName2");
								$LINK1 = " target='_blank'";
							}else{
								$LINK = $rsD->field("strName2")."?Class1_PKey=".$Class1_PKey."&Class2_PKey=".SqlFilter($rs1->field("PKey"),"int")."&PKey=".$rsD->field("PKey");
							}
						}else{
							$LINK = "page_detail.php?Class1_PKey=".$Class1_PKey."&Class2_PKey=".SqlFilter($rs1->field("PKey"),"int")."&PKey=".$rsD->field("PKey");	
						}
					}else{
						$LINK = "page_detail.php?Class1_PKey=".$Class1_PKey."&Class2_PKey=".SqlFilter($rs1->field("PKey"),"int")."&PKey=".$rsD->field("PKey");
					}
				}
        ?>
                <li class="<?php if ( strval($Class2_PKey) == strval($rs1->field("PKey")) ) { ?>on<?php } ?>">
                <?php
					/***判斷是否顯示次類別***/
		            if ( $num2 >= 2 ){
						echo "<a href=\"#\">".$rs1->field("strName_c")."<i class=\"fa fa-caret-down\"></i>";
					}else{
						echo "<a href=\"page_detail.php?Class1_PKey=".$Class1_PKey."&Class2_PKey=".$rs1->field("PKey").$subReq."\">".$rs1->field("strName_c");
					}
				?>
                  	 </a>
                <?php if ( $num2 >= 2 ){?>
                  <ul>
					<?php
                            /*取得次類別(標題)資料*/
                            $SQL  = " Select * From $dbName Where intLang = 2 and Class1_PKey = ".SqlFilter($Class1_PKey,"int"). " And Class2_PKey = ".SqlFilter($rs1->field("PKey"),"int")." And";
                            $SQL .= " Upload = 'Yes' Order By Sort";
                            $rs11 = new recordset($SQL);
                            while (! $rs11->eof ){
                    ?>
                            <li class="<?php if ( strval($PKey) == strval($rs11->field("PKey")) ) { ?>on<?php } ?>"> <a href="page_detail.php?Class1_PKey=<? echo $rs11->field("Class1_PKey")?>&Class2_PKey=<? echo $rs11->field("Class2_PKey")?>&PKey=<? echo $rs11->field("PKey").$subReq?>">
                              <? echo $rs11->field("strName_c") ?>
                              </a> </li>
					<?php
                                $rs11->movenext();
                            }
                    ?>
                  </ul>
                <?php }?>
                </li>
        <?php
                $rs1->movenext();
            }
			?>
    </ul>
  </div>
</div>




<?php } elseif( $pageName=="p5" or $pageName=="p9" ){ ?>

<div class="container_menu2"> <a class="toggleMenu2 color_0" href="#">【
  <?php echo $p5;?>
  】<span><i class="fa fa-caret-down"></i></span></a>
  <div class="menu_scrool2">
    <ul class="nav_list2">
    
		<?php
            /***取得分類清單***/
            $SQL = "Select PKey, Class1_PKey, strName_c From ".$dbName."_class Where intLang = 2 and Class1_PKey = ".SqlFilter($Class1_PKey,"int")." And Upload = 'Yes' Order By Sort";
            $rs1 = new recordset($SQL);
            while (! $rs1->eof ){
				$LINK = "";
				
				/*判斷顯示型態*/
				$SQL = "Select * From $dbName Where intLang = 2 and Class1_PKey = ".SqlFilter($Class1_PKey,"int")." And Class2_PKey = ".SqlFilter($rs1->field("PKey"),"int")." Order By Sort";
				$rsD = new recordset($SQL);
				if (! $rsD->eof ){
					
					/***取得資料筆數***/
					$SQL = "Select * From $dbName Where intLang = 2 and Class1_PKey = ".SqlFilter($Class1_PKey,"int")." And Class2_PKey = ".SqlFilter($rs1->field("PKey"),"int");
					$result = mysql_query($SQL);
					$num2 = mysql_num_rows($result);
					
					if ( $rsD->field("showType") == 1 ){
						if ( $num2 == 1 ){
							/*判斷是否為外部網址*/
							if ( preg_match("/www/",$rsD->field("strName2")) == true || preg_match("/WWW/",$rsD->field("strName2")) == true ){
								$LINK = "http://".$rsD->field("strName2");
								$LINK1 = " target='_blank'";
							}else{
								$LINK = $rsD->field("strName2")."?Class1_PKey=".$Class1_PKey."&Class2_PKey=".SqlFilter($rs1->field("PKey"),"int")."&PKey=".$rsD->field("PKey");
							}
						}else{
							$LINK = "page_detail.php?Class1_PKey=".$Class1_PKey."&Class2_PKey=".SqlFilter($rs1->field("PKey"),"int")."&PKey=".$rsD->field("PKey");	
						}
					}else{
						$LINK = "page_detail.php?Class1_PKey=".$Class1_PKey."&Class2_PKey=".SqlFilter($rs1->field("PKey"),"int")."&PKey=".$rsD->field("PKey");
					}
				}
        ?>
    
    
                <li class="<?php if ( strval($Class2_PKey) == strval($rs1->field("PKey")) ) { ?>on<?php } ?>">
                <?php
					/***判斷是否顯示次類別***/
		            if ( $num2 >= 2 ){
						echo "<a href=\"#\">".$rs1->field("strName_c")."<i class=\"fa fa-caret-down\"></i>";
					}else{
						echo "<a href=".$LINK.">".$rs1->field("strName_c");
					}
				?>
                  	 </a>
                <?php if ( $num2 >= 2 ){?>
                  <ul>
					<?php
                            /*取得次類別(標題)資料*/
                            $SQL  = " Select * From $dbName Where intLang = 2 and Class1_PKey = ".SqlFilter($Class1_PKey,"int"). " And Class2_PKey = ".SqlFilter($rs1->field("PKey"),"int")." And";
                            $SQL .= " Upload = 'Yes' Order By Sort";
                            $rs11 = new recordset($SQL);
                            while (! $rs11->eof ){
								$LINK1="";
								if ( $rs11->field("showType") == 1 ){
									/*判斷是否為外部網址*/
									if ( preg_match("/www/",$rs11->field("strName2")) == true || preg_match("/WWW/",$rs11->field("strName2")) == true ){
										$LINK = "http://".$rs11->field("strName2");
										$LINK1 = " target='_blank'";
									}else{
										$LINK = $rs11->field("strName2")."?Class1_PKey=".$Class1_PKey."&Class2_PKey=".SqlFilter($rs11->field("PKey"),"int")."&PKey=".$rs11->field("PKey");
									}
								}else{
									$LINK = "page_detail.php?Class1_PKey=".$Class1_PKey."&Class2_PKey=".SqlFilter($rs11->field("PKey"),"int")."&PKey=".$rs11->field("PKey");
								}
								
                    ?>
                            <li class="<?php if ( strval($PKey) == strval($rs11->field("PKey")) ) { ?>on<?php } ?>"> <a href="<? echo $LINK?>" <? echo $LINK1?>>
                              <? echo $rs11->field("strName_c") ?>
                              </a> </li>
					<?php
                                $rs11->movenext();
                            }
                    ?>
                  </ul>
                <?php }?>
                </li>
        <?php
                $rs1->movenext();
            }
		?>
        
        
    </ul>
  </div>
</div>













<?php } elseif( $pageName=="p6" ){ ?>
<div class="container_menu2"> <a class="toggleMenu2 color_0" href="#">【
  <?php echo $p6;?>
  】<span><i class="fa fa-caret-down"></i></span></a>
  <div class="menu_scrool2">
    <ul class="nav_list2">
    
    
		<?php
            /***取得分類清單***/
            $SQL = "Select PKey, Class1_PKey, strName_c From ".$dbName."_class Where intLang = 2 and Class1_PKey = ".SqlFilter($Class1_PKey,"int")." And Upload = 'Yes' Order By Sort";
            $rs1 = new recordset($SQL);
            while (! $rs1->eof ){
				$LINK = "";
				
				/*判斷顯示型態*/
				$SQL = "Select * From $dbName Where intLang = 2 and Class1_PKey = ".SqlFilter($Class1_PKey,"int")." And Class2_PKey = ".SqlFilter($rs1->field("PKey"),"int")." Order By Sort";
				$rsD = new recordset($SQL);
				if (! $rsD->eof ){
					
					$LINK = "";
					
					/***取得資料筆數***/
					$SQL = "Select * From $dbName Where intLang = 2 and Class1_PKey = ".SqlFilter($Class1_PKey,"int")." And Class2_PKey = ".SqlFilter($rs1->field("PKey"),"int");
					$result = mysql_query($SQL);
					$num2 = mysql_num_rows($result);
					
					if ( $rsD->field("showType") == 1 ){
						if ( $num2 == 1 ){
							/*判斷是否為外部網址*/
							if ( preg_match("/www/",$rsD->field("strName2")) == true || preg_match("/WWW/",$rsD->field("strName2")) == true ){
								$LINK = "http://".$rsD->field("strName2");
								$LINK1 = " target='_blank'";
							}else{
								$LINK = $rsD->field("strName2")."?Class1_PKey=".$Class1_PKey."&Class2_PKey=".SqlFilter($rs1->field("PKey"),"int")."&PKey=".$rsD->field("PKey");
							}
						}else{
							$LINK = "page_detail.php?Class1_PKey=".$Class1_PKey."&Class2_PKey=".SqlFilter($rs1->field("PKey"),"int")."&PKey=".$rsD->field("PKey");	
						}
					}else{
						$LINK = "page_detail.php?Class1_PKey=".$Class1_PKey."&Class2_PKey=".SqlFilter($rs1->field("PKey"),"int")."&PKey=".$rsD->field("PKey");
					}
				}
        ?>
    
    
    
                <li class="<?php if ( strval($Class2_PKey) == strval($rs1->field("PKey")) ) { ?>on<?php } ?>">
                <?php
					/***判斷是否顯示次類別***/
		            if ( $num2 >= 2 ){
						echo "<a href=\"#\">".$rs1->field("strName_c")."<i class=\"fa fa-caret-down\"></i>";
					}else{
						echo "<a href=".$LINK.">".$rs1->field("strName_c");
					}
				?>
                  	 </a>
                <?php if ( $num2 >= 2 ){?>
                  <ul>
					<?php
                            /*取得次類別(標題)資料*/
                            $SQL  = " Select * From $dbName Where intLang = 2 and Class1_PKey = ".SqlFilter($Class1_PKey,"int"). " And Class2_PKey = ".SqlFilter($rs1->field("PKey"),"int")." And";
                            $SQL .= " Upload = 'Yes' Order By Sort";
                            $rs11 = new recordset($SQL);
                            while (! $rs11->eof ){
								$LINK1="";
								if ( $rs11->field("showType") == 1 ){
									/*判斷是否為外部網址*/
									if ( preg_match("/www/",$rs11->field("strName2")) == true || preg_match("/WWW/",$rs11->field("strName2")) == true ){
										$LINK = "http://".$rs11->field("strName2");
										$LINK1 = " target='_blank'";
									}else{
										$LINK = $rs11->field("strName2")."?Class1_PKey=".$Class1_PKey."&Class2_PKey=".SqlFilter($rs11->field("Class2_PKey"),"int")."&PKey=".$rs11->field("PKey");
									}
								}else{
									$LINK = "page_detail.php?Class1_PKey=".$Class1_PKey."&Class2_PKey=".SqlFilter($rs11->field("Class2_PKey"),"int")."&PKey=".$rs11->field("PKey");
								}
								
                    ?>
                            <li class="<?php if ( strval($PKey) == strval($rs11->field("PKey")) ) { ?>on<?php } ?>"> <a href="<? echo $LINK?>" <? echo $LINK1?>>
                              <? echo $rs11->field("strName_c") ?>
                              </a> </li>
					<?php
                                $rs11->movenext();
                            }
                    ?>
                  </ul>
                <?php }?>
                </li>
      
      
        <?php
                $rs1->movenext();
            }
		?>
      
    </ul>
  </div>
</div>
<?php } ?>
