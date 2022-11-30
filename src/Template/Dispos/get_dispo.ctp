<tr>
	<td class="st_date"><input type="text" size="20" class="select text datedebut" name="data[Annonce][dbt_at][]"></td>
	<td class="st_date"><input type="text" size="20" class="select text datefin" name="data[Annonce][fin_at][]"></td>
	<td><input type="text"  size="10" class="select text" name="data[Annonce][prix][]"></td>
	<td><input type="checkbox" value="1" name="data[Annonce][promo_yn][]" ></td>
	<td><input type="text" size="10" class="select text" name="data[Annonce][promo_px][]"></td>
</tr>
<script>
function set_date(){
		$(".datedebut" ).datepicker({
					 showOn: 'button',
					buttonImage: '<?php echo $this->base?>/img/calendrier.png',
					buttonImageOnly: true,
                    dateFormat: "dd/mm/yy",
                    minDate: 0,
                    onSelect: function( selectedDate ) {
								a_date=selectedDate.split("/");
								
                                testm = new Date(a_date[2]+'-'+a_date[1]+'-'+a_date[0]);
								
                                testm.setDate(testm.getDate());
								
					$( ".datefin" ).datepicker( "option", "minDate", testm );
					}
            });
			$(".datefin" ).datepicker({ 
					 showOn: 'button',
					buttonImage: '<?php echo $this->base?>/img/calendrier.png',
					buttonImageOnly: true,
                    dateFormat: "dd/mm/yy"
			});
	}
    $(document).ready(function() {
       
			set_date();
			});
</script>        