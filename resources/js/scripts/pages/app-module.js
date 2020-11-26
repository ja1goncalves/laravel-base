/*=========================================================================================
    File Name: app-module.js
    Description: User page JS
    --------------------------------------------------------------------------------------
    Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/
$(document).ready(function () {

  var bDel = document.getElementById('del-module')
  if (bDel) {
    bDel.addEventListener("click", function () {
      $.ajax({
        dataType: 'json',
        method: 'delete',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: location.origin+"/module/del/"+document.getElementById('module-id').innerText,
        success: function (res) {
          location.replace(location.origin+"/modules/")
        },
        error: function (res) {
          toastr.error(res.message)
        }
      })
    });
  }

  var isRtl;
  if ( $('html').attr('data-textdirection') == 'rtl' ) {
    isRtl = true;
  } else {
    isRtl = false;
  }

  //  Rendering badge in status column
  var customBadgeHTML = function (params) {
    var color = "";
    if (params.value == 1) {
      color = "success"
      return "<div class='badge badge-pill badge-light-" + color + "' >Ativo</div>"
    } else if (params.value == 0) {
      color = "warning";
      return "<div class='badge badge-pill badge-light-" + color + "' >Inativo</div>"
    } else {
      color = "primary";
      return "<div class='badge badge-pill badge-light-" + color + "' >Indefinido</div>"
    }
  }

  //  Rendering bullet in verified column
  // var customBulletHTML = function (params) {
  //   var color = "";
  //   if (params.value == true) {
  //     color = "success"
  //     return "<div class='bullet bullet-sm bullet-" + color + "' >" + "</div>"
  //   } else if (params.value == false) {
  //     color = "secondary";
  //     return "<div class='bullet bullet-sm bullet-" + color + "' >" + "</div>"
  //   }
  // }

  // Renering Icons in Actions column
  var customIconsHTML = function (params) {
    var usersIcons = document.createElement("span");
    var editIconHTML = "<a href='modules/edit/"+params.data.id+"'><i class='users-edit-icon feather icon-edit-1 mr-50'></i></a>"
    var deleteIconHTML = document.createElement('i');
    var attr = document.createAttribute("class")
    attr.value = "modules-delete-icon feather icon-trash-2"
    deleteIconHTML.setAttributeNode(attr);
    // selected row delete functionality
    deleteIconHTML.addEventListener("click", function () {
      $.ajax({
        dataType: 'json',
        method: 'delete',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: location.origin+"/modules/del/"+params.data.id,
        success: function (res) {
          deleteArr = [
            params.data
          ];
          // var selectedData = gridOptions.api.getSelectedRows();
          gridOptions.api.updateRowData({
            remove: deleteArr
          });
        },
        error: function (res) {
          toastr.error(res.message)
        }
      })
    });
    usersIcons.appendChild($.parseHTML(editIconHTML)[0]);
    usersIcons.appendChild(deleteIconHTML);
    return usersIcons
  }

  // ag-grid
  /*** COLUMN DEFINE ***/

  var columnDefs = [{
      headerName: 'ID',
      field: 'id',
      width: 125,
      filter: true,
      checkboxSelection: true,
      headerCheckboxSelectionFilteredOnly: true,
      headerCheckboxSelection: true,
    },
    {
      headerName: 'Nome',
      field: 'name',
      filter: true,
      width: 200,
    },
    {
      headerName: 'Ícone',
      field: 'icon',
      filter: true,
      width: 180,
    },
    {
      headerName: 'Rota',
      field: 'route',
      filter: true,
      width: 150,
    },
    {
      headerName: 'Status',
      field: 'status',
      filter: true,
      width: 150,
      cellRenderer: customBadgeHTML,
      cellStyle: {
        "text-align": "center"
      }
    },
    {
      headerName: 'Ações',
      field: 'transactions',
      width: 150,
      cellRenderer: customIconsHTML,
    }
  ];

  /*** GRID OPTIONS ***/
  var gridOptions = {
    defaultColDef: {
      sortable: true
    },
    enableRtl: isRtl,
    columnDefs: columnDefs,
    rowSelection: "multiple",
    floatingFilter: true,
    filter: true,
    pagination: true,
    paginationPageSize: 20,
    pivotPanelShow: "always",
    colResizeDefault: "shift",
    animateRows: true,
    resizable: true
  };
  if (document.getElementById("myGrid")) {
    /*** DEFINED TABLE VARIABLE ***/
    var gridTable = document.getElementById("myGrid");

    /*** GET TABLE DATA FROM URL ***/
    $.ajax({
      dataType: 'json',
      url: location.origin+"/modules",
      success: function (res) {
        gridOptions.api.setRowData(res.data);
      },
      error: function (res) {
        toastr.error(res.message)
        gridOptions.api.setRowData([]);
      }
    })

    /*** FILTER TABLE ***/
    function updateSearchQuery(val) {
      gridOptions.api.setQuickFilter(val);
    }

    $(".ag-grid-filter").on("keyup", function () {
      updateSearchQuery($(this).val());
    });

    /*** CHANGE DATA PER PAGE ***/
    function changePageSize(value) {
      gridOptions.api.paginationSetPageSize(Number(value));
    }

    $(".sort-dropdown .dropdown-item").on("click", function () {
      var $this = $(this);
      changePageSize($this.text());
      $(".filter-btn").text("1 - " + $this.text() + " of 50");
    });

    /*** EXPORT AS CSV BTN ***/
    $(".ag-grid-export-btn").on("click", function (params) {
      gridOptions.api.exportDataAsCsv();
    });

    //  filter data function
    var filterData = function agSetColumnFilter(column, val) {
      var filter = gridOptions.api.getFilterInstance(column)
      var modelObj = null
      if (val !== "all") {
        modelObj = {
          type: "equals",
          filter: val
        }
      }
      filter.setModel(modelObj)
      gridOptions.api.onFilterChanged()
    }
    //  filter inside role
    $("#modules-list-role").on("change", function () {
      var usersListRole = $("#users-list-role").val();
      filterData("role", usersListRole)
    });
    //  filter inside verified
    $("#modules-list-verified").on("change", function () {
      var usersListVerified = $("#users-list-verified").val();
      filterData("is_verified", usersListVerified)
    });
    //  filter inside status
    $("#modules-list-status").on("change", function () {
      var usersListStatus = $("#users-list-status").val();
      filterData("status", usersListStatus)
    });
    //  filter inside department
    $("#modules-list-department").on("change", function () {
      var usersListDepartment = $("#users-list-department").val();
      filterData("department", usersListDepartment)
    });
    // filter reset
    $(".modules-data-filter").click(function () {
      $('#modules-list-role').prop('selectedIndex', 0);
      $('#modules-list-role').change();
      $('#modules-list-status').prop('selectedIndex', 0);
      $('#modules-list-status').change();
      $('#modules-list-verified').prop('selectedIndex', 0);
      $('#modules-list-verified').change();
      $('#modules-list-department').prop('selectedIndex', 0);
      $('#modules-list-department').change();
    });

    /*** INIT TABLE ***/
    new agGrid.Grid(gridTable, gridOptions);
  }
  // users language select
  if ($("#modules-language-select2").length > 0) {
    $("#users-language-select2").select2({
      dropdownAutoWidth: true,
      width: '100%'
    });
  }
  // users music select
  if ($("#modules-music-select2").length > 0) {
    $("#users-music-select2").select2({
      dropdownAutoWidth: true,
      width: '100%'
    });
  }
  // users movies select
  if ($("#modules-movies-select2").length > 0) {
    $("#users-movies-select2").select2({
      dropdownAutoWidth: true,
      width: '100%'
    });
  }
  // users birthdate date
  if ($(".birthdate-picker").length > 0) {
    $('.birthdate-picker').pickadate({
      format: 'mmmm, d, yyyy'
    });
  }
  // Input, Select, Textarea validations except submit button validation initialization
  if ($(".modules-edit").length > 0) {
    $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
  }
});
