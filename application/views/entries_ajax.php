<?
if (!empty($entries)) {
	foreach($entries as $id=>$entry) {
?>
						<tr>
							<td><p><a href="<?php echo base_url("entries/edit/".$entry->getID()); ?>"><?php echo $entry->getDate(); ?></a></p></td>
							<td><p><?php echo $routes[$entry->getRouteID()]->getName(); ?></p></td>
							<td><p><?php echo $run_types[$entry->getTypeID()]; ?></p></td>
							<td><p><?php echo $entry->getDistance(); ?> km</p></td>
							<td><p><?php echo $entry->getTime(); ?></p></td>
							<td><p><?php echo $entry->getPace(); ?></p></td>
							<td><p class="text-right"><a class="text-danger" href="<?php echo base_url("entries/delete/".$entry->getID()); ?>"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</a></p></td>
						</tr>
<?
	}
	if (($offset + $limit) < $count) {
?>

						<tr id="load-all-entries">
							<td colspan="7"><p class="text-center"><a href="javascript:void(0);" class="btn btn-primary load-all-entries-button" role="button"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span> Load More Entries</a></p></td>
						</tr>

	<script>
		$(function() {
			$('.load-all-entries-button').click(function() {
				$('#load-all-entries').remove();
				$.ajax({url: '<? echo base_url("entries/show/".$limit."/".($page+1)); ?>', success: function(result){
					$('#entries-list').append(result);
				}});
			});
		});
	</script>

<?
	}
}
?>