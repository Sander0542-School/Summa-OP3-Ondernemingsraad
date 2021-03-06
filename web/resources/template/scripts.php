    <script src="/styles/jquery/jquery.min.js"></script>
    <script src="/styles/materialize/js/materialize.min.js"></script>
    <script src="/styles/custom/custom.js"></script>

    
    <script>
      $(document).ready(function () {
        $('.fixed-action-btn').floatingActionButton();
        $('.modal').modal();
        $('.modal.default').modal('open');
        $('select').formSelect();
        M.textareaAutoResize($('textarea'));
        $('.tooltipped').tooltip();
        $('.collapsible').collapsible();
        $('.dropdown-trigger').dropdown();
        $('.datepicker').each(function() {
          $(this).datepicker({
            format: 'dd-mm-yyyy',
            firstDay: 1,
            defaultDate: new Date($(this).data('date')),
            setDefaultDate: true,
            showDaysInNextAndPreviousMonths: true,
            selectYears: 5,
            container: document.body,
            i18n: {
              cancel: 'Annuleer',
              done: 'Selecteer',
              months: [
                'Januari',
                'Februari',
                'Maart',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Augustus',
                'September',
                'Oktober',
                'November',
                'December'
              ],
              monthsShort: [
                'Jan',
                'Feb',
                'Mrt',
                'Apr',
                'Mei',
                'Jun',
                'Jul',
                'Aug',
                'Sep',
                'Okt',
                'Nov',
                'Dec'
              ],
              weekdays: [
                'Zondag',
                'Maandag',
                'Dinsdag',
                'Woensdag',
                'Donderdag',
                'Vrijdag',
                'Zaterdag'
              ],
              weekdaysShort: [
                'Zo',
                'Ma',
                'Di',
                'Wo',
                'Do',
                'Vr',
                'Za'
              ],
              weekdaysAbbrev: ['Z', 'M', 'D', 'W', 'D', 'V', 'Z']
            }
          });
        });
        $('.tabs').tabs();
        $('.tap-target').tapTarget();
      });
    </script>
