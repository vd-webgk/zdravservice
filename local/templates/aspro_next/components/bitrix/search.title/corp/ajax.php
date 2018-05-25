<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?if (empty($arResult["CATEGORIES"])) return;?>
<div class="bx_searche scrollbar">
	<?foreach($arResult["CATEGORIES"] as $category_id => $arCategory):?>
		<?foreach($arCategory["ITEMS"] as $i => $arItem):?>
			<?//=$arCategory["TITLE"]?>
			<?if($category_id === "all"):?>
				<div class="bx_item_block all_result">
					<div class="maxwidth-theme">
						<div class="bx_item_element">
							<a class="all_result_title btn btn-default white bold" href="<?=$arItem["URL"]?>"><?=$arItem["NAME"]?></a>
						</div>
						<div style="clear:both;"></div>
					</div>
				</div>
			<?elseif(isset($arResult["ELEMENTS"][$arItem["ITEM_ID"]])):
				$arElement = $arResult["ELEMENTS"][$arItem["ITEM_ID"]];?>
				<a class="bx_item_block" href="<?=$arItem["URL"]?>">
					<div class="maxwidth-theme">
						<div class="bx_img_element">
							<?if(is_array($arElement["PICTURE"])):?>
								<img src="<?=$arElement["PICTURE"]["src"]?>">
							<?else:?>
								<img src="<?=SITE_TEMPLATE_PATH?>/images/no_photo_small.png" width="38" height="38">
							<?endif;?>
						</div>
						<div class="bx_item_element">
							<span><?=$arItem["NAME"]?></span>
							<div class="price cost prices">
								<div class="title-search-price">
									<?if($arElement["MIN_PRICE"]){?>
										<?if($arElement["MIN_PRICE"]["DISCOUNT_VALUE"] < $arElement["MIN_PRICE"]["VALUE"]):?>
											<div class="price"><?=$arElement["MIN_PRICE"]["PRINT_DISCOUNT_VALUE"]?></div>
											<div class="price discount">
												<strike><?=$arElement["MIN_PRICE"]["PRINT_VALUE"]?></strike>
											</div>
										<?else:?>
											<div class="price"><?=$arElement["MIN_PRICE"]["PRINT_VALUE"]?></div>
										<?endif;?>
									<?}else{?>
										<?foreach($arElement["PRICES"] as $code=>$arPrice):?>
											<?if($arPrice["CAN_ACCESS"]):?>
												<?if (count($arElement["PRICES"])>1):?>
													<div class="price_name"><?=$arResult["PRICES"][$code]["TITLE"];?></div>
												<?endif;?>
												<?if($arPrice["DISCOUNT_VALUE"] < $arPrice["VALUE"]):?>
													<div class="price"><?=$arPrice["PRINT_DISCOUNT_VALUE"]?></div>
													<div class="price discount">
														<strike><?=$arPrice["PRINT_VALUE"]?></strike>
													</div>
												<?else:?>
													<div class="price"><?=$arPrice["PRINT_VALUE"]?></div>
												<?endif;?>
											<?endif;?>
										<?endforeach;?>
									<?}?>
								</div>
							</div>
                                                       
						</div>
                        <div class="to_basket_from_search">
                            <svg class="basket_in_top_search" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22">
                              <defs>
                                <style>
                                  .cls-1 {
                                    fill: #fff;
                                    fill-rule: evenodd;
                                  }
                                </style>
                              </defs>
                              <path data-name="Ellipse 2 copy 6" class="cls-1" d="M1507,122l-0.99,1.009L1492,123l-1-1-1-9h-3a0.88,0.88,0,0,1-1-1,1.059,1.059,0,0,1,1.22-1h2.45c0.31,0,.63.006,0.63,0.006a1.272,1.272,0,0,1,1.4.917l0.41,3.077H1507l1,1v1ZM1492.24,117l0.43,3.995h12.69l0.82-4Zm2.27,7.989a3.5,3.5,0,1,1-3.5,3.5A3.495,3.495,0,0,1,1494.51,124.993Zm8.99,0a3.5,3.5,0,1,1-3.49,3.5A3.5,3.5,0,0,1,1503.5,124.993Zm-9,2.006a1.5,1.5,0,1,1-1.5,1.5A1.5,1.5,0,0,1,1494.5,127Zm9,0a1.5,1.5,0,1,1-1.5,1.5A1.5,1.5,0,0,1,1503.5,127Z" transform="translate(-1486 -111)"/>
                              </svg>
                        </div>               
						<div style="clear:both;"></div>
					</div>
                    
				</a>
			<?else:?>
				<?if($arItem["MODULE_ID"]):?>
					<a class="bx_item_block others_result" href="<?=$arItem["URL"]?>">
						<div class="maxwidth-theme">
							<div class="bx_item_element">
								<span><?=$arItem["NAME"]?></span>
							</div>
							<div style="clear:both;"></div>
						</div>
					</a>
				<?endif;?>
			<?endif;?>
		<?endforeach;?>
	<?endforeach;?>
</div>