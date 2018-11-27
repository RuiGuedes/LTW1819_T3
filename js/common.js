'use strict'

let filter = document.getElementById('filterID')
filter.addEventListener('change', updateFilter)

function updateFilter() {
  filter.parentElement.submit()
}
