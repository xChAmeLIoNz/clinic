var groupColumn = 1;
var table = $('#ordini').DataTable({
         language: {
            url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/it-IT.json',
      },
      columnDefs: [{ visible: false, targets: groupColumn }],
      order: [[groupColumn, 'asc']],
      displayLength: 25,
      drawCallback: function (settings) {
         var api = this.api();
         var rows = api.rows({ page: 'current' }).nodes();
         var last = null;

         api
            .column(groupColumn, { page: 'current' })
            .data()
            .each(function (group, i) {
                  if (last !== group) {
                     $(rows)
                        .eq(i)
                        .before('<tr class="group"><td colspan="5">' + group + '</td></tr>');

                     last = group;
                  }
            });
      },
});

// Order by the grouping
$('#clienti tbody').on('click', 'tr.group', function () {
      var currentOrder = table.order()[0];
      if (currentOrder[0] === groupColumn && currentOrder[1] === 'asc') {
         table.order([groupColumn, 'desc']).draw();
      } else {
         table.order([groupColumn, 'asc']).draw();
      }
});