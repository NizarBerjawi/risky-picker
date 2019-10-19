document.addEventListener('DOMContentLoaded', function() {
  var elems = document.querySelectorAll('.fixed-action-btn');
  var instances = M.FloatingActionButton.init(elems, {});
});

document.addEventListener('DOMContentLoaded', function() {
  var elems = document.querySelectorAll('.materialboxed');
  var instances = M.Materialbox.init(elems, {});
});

document.addEventListener('DOMContentLoaded', function() {
  var elems = document.querySelectorAll('select');
  var instances = M.FormSelect.init(elems, {});
});

document.addEventListener('DOMContentLoaded', function() {
   var elems = document.querySelectorAll('.timepicker');
   var instances = M.Timepicker.init(elems, {});
 });

 document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.sidenav');
    var instances = M.Sidenav.init(elems, {});
 });


  // Initialize collapsible (uncomment the lines below if you use the dropdown variation)
  var collapsibleElem = document.querySelector('.collapsible');
  var collapsibleInstance = M.Collapsible.init(collapsibleElem, {})

 document.addEventListener('DOMContentLoaded', function() {
     var el = document.querySelectorAll('.tabs');
     var instance = M.Tabs.init(el, {});
 });

 document.addEventListener('DOMContentLoaded', function() {
   var elems = document.querySelectorAll('.modal');
   var instances = M.Modal.init(elems, {});
 });

 document.addEventListener('DOMContentLoaded', function() {
   var elems = document.querySelectorAll('.tooltipped');
   var instances = M.Tooltip.init(elems, {});
 });
