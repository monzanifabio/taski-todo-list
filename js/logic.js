// Execute when the page load
$(document).ready(function(){
  refreshTodos(); // Get latest todos
  refreshCompleted(); // Get latest completed todos
  refreshFolders(); // Get latest folders
  countTodos(); // Get the number of todos
  countCompleted(); // Get the number of completed todos
  clearAll();
  recentLabels();
  //labelList();
  });

  // Show clear all button
  function clearAll() {
    var todos_completed = $('#count_completed').text();
    if (todos_completed == 0) {
      $('#clear_all').hide();
    } else {
      $('#clear_all').show();
    }
  };

  //Display used labels
  function recentLabels() {
    var get_user_id = $('#user_id').val();
    $.ajax({
          type: "GET",
          url: "src/get-labels.php",
          data: {
            'user_id': get_user_id,
          },
          success: function(response){
              $("#display_labels").html(response);
          }
      });
  };

  //Display list of labels
  function labelList() {
    var get_user_id = $('#user_id').val();
    $.ajax({
          type: "GET",
          url: "src/get-labels-list.php",
          data: {
            'user_id': get_user_id,
          },
          success: function(response){
              $("#display_labels_list").html(response);
          }
      });
  };

  //Get all todos
  function getAllTodos() {
    localStorage.setItem('folder-name', 'Tasks')
    var savedFilter = localStorage.setItem("folder", 0);
    var get_user_id = $('#user_id').val();
    var folder_title = $('[name="folderTitle"]').text('Tasks').attr('id', '0');
    var savedFilter = localStorage.getItem("filter");

    $.ajax({
          type: "GET",
          url: "src/get-todos.php",
          data: {
            'user_id': get_user_id,
            'filter': savedFilter,
          },
          success: function(response){
              $("#display_area").html(response);
              $('.hidden').hide();
              recentLabels();
              countTodos();
              refreshCompleted();
          }
      });
    };

  // Refresh todo list
  function refreshTodos() {
    var saveFolderName = localStorage.getItem('folder-name');
    var folder_title = $('[name="folderTitle"]').text(saveFolderName);
    var savedFolder = localStorage.getItem('folder');
    var savedFilter = localStorage.getItem("filter");
    var get_user_id = $('#user_id').val();
    var folder_id = $('[name="folderTitle"]').attr('id');
    $.ajax({
          type: "GET",
          url: "src/get-todos.php",
          data: {
            'user_id': get_user_id,
            'filter': savedFilter,
            'folder_id': savedFolder,
          },
          success: function(response){
              $("#display_area").html(response);
              $('.hidden').hide();
              recentLabels();
              refreshCompleted();
          }
      });
    };

  // Get todos in folder selected
  function getTodosFolder(elem) {
    var folderName = $(elem).text();
    //Change the title to the selected folder name
    var title = $('[name="folderTitle"]').text(folderName);
    var get_user_id = $('#user_id').val();
    var get_folder_id = $(elem).attr('id');
    var savedFolder = localStorage.setItem("folder", get_folder_id);
    localStorage.setItem('folder-name', folderName);
    title.attr('id',get_folder_id);
    $.ajax({
          type: "GET",
          url: "src/get-todos-folder.php",
          data: {
            'folder_id': get_folder_id,
            'user_id': get_user_id,
          },
          success: function(response){
              $("#display_area").html(response);
              $('.hidden').hide();
              countTodos();
              refreshCompleted();
          }
      });
    };

  //Refresh folders
  function refreshFolders() {
    var get_user_id = $('#user_id').val();
    $.ajax({
          type: "GET",
          url: "src/get-folders.php",
          data: {
            'user_id': get_user_id,
          },
          success: function(response){
              $("#display_folders").html(response);
          }
      });
    };

  //Refresh completed todo list
  function refreshCompleted() {
    var get_user_id = $('#user_id').val();
    var folder_id = localStorage.getItem('folder');
    $.ajax({
          type: "GET",
          url: "src/get-completed.php",
          data: {
            'user_id': get_user_id,
            'folder_id': folder_id,
          },
          success: function(response){
              $("#completed_area").html(response);
          }
      });
  };

  //Count todos
  function countTodos() {
    var get_user_id = $('#user_id').val();
    var savedFolder = localStorage.getItem('folder');
    var folder_id = $('[name="folderTitle"]').attr('id');
    $.ajax({
          type: "GET",
          url: "src/count-todo.php",
          data: {
            'user_id': get_user_id,
            'folder_id': savedFolder,
          },
          success: function(response){
              $("span[id='count_todos']").html(response);
          }
      });
    };

  //Count completed
  function countCompleted() {
    var get_user_id = $('#user_id').val();
    var folder_id = localStorage.getItem('folder');
    $.ajax({
          type: "GET",
          url: "src/count-completed.php",
          data: {
            'user_id': get_user_id,
            'folder_id': folder_id,
          },
          success: function(response){
              $("#count_completed").html(response);
              clearAll();
          }
      });
    };

  // Filter todo by
  function orderBy(elem) {
    var get_user_id = $('#user_id').val();
    var filter = $(elem).attr('id');
    var folder_id = $('[name="folderTitle"]').attr('id');
    //Save the filtering in localstorage
    var savedFilter = localStorage.setItem("filter", filter);
    $.ajax({
      url: 'src/get-todos.php',
      type: 'GET',
      data: {
        'user_id': get_user_id,
        'filter': filter,
        'folder_id': folder_id,
      },
      success: function(response){
        $("#display_area").html(response);
        $('.hidden').hide();
        $('hidden').hide();
      }
    });
  };

  // Add todo to database
  $('#add_todo_btn').click(function(){
    var user_id = $('#user_id').val();
    var todo = $('#todo_text').val();
    var folder_id = $('[name="folderTitle"]').attr('id');
    $.ajax({
      url: 'src/add-todo.php',
      type: 'POST',
      data: {
        'user_id': user_id,
        'todo': todo,
        'folder_id': folder_id,
      },
      success: function(response){
        $('#todo_text').val('');
        refreshTodos();
        countTodos();
        refreshFolders();
      }
    });
    return false;
  });

  //Create folders
  $('#create_folder').click(function() {
    var user_id = $('#user_id').val();
    var folder_name = $('#folder_name').val();
    $.ajax({
      url: 'src/create-folder.php',
      type: 'POST',
      data: {
        'user_id': user_id,
        'folder_name': folder_name,
      },
      success: function(response){
        $('#folder_name').val('');
        $('#folderModal').modal('hide');
        refreshFolders();
        refreshTodos();
        countTodos();
      }
    });
    return false;
  });

  //Rename folder
  function renameFolder(elem) {
    $('#folder_id').val($(elem).attr('id'));
    $('#renameFolderModal').modal();
  };

  $('#rename_folder_btn').click(function() {
    var folder_id = $('#folder_id').val();
    console.log(folder_id);
    var newFolderName = $('#selected_folder_name').val()
    console.log(newFolderName);
    if (newFolderName == "") {
      // $('#folder_warning').text("You need to add a name for your folder");
    } else {
      $.ajax({
        url: 'src/rename-folder.php',
        type: 'POST',
        data: {
          'folder_id': folder_id,
          'folder_name': newFolderName,
        },
        success: function(response){
          $('#selected_folder_name').val('');
          $('#renameFolderModal').modal('hide');
          refreshFolders();
        }
      });
      return false;
    };
  });

  //Create label modal launcher
  function labelTodo(elem) {
    var todo_id = $(elem).attr('id');
    $('#labelModal').modal();
    $('#label_todo_id').val(todo_id);
  };

  //Create label
  $('#create_label').click(function() {
    var todo_id = $('#label_todo_id').val();
    var label_name = $('#label_name').val();
    var label_color = $('input[name=labelColor]:checked', '#labelForm').val()
    if (label_name == "") {
      $('#label_warning').text("Don't forget to name your label");
    } else {
      $.ajax({
        url: 'src/add-label.php',
        type: 'POST',
        data: {
          'todo_id': todo_id,
          'label_name': label_name,
          'label_color': label_color,
        },
        success: function(response){
          $('#label_name').val('');
          $('#label_warning').text('')
          $('#labelModal').modal('hide');
          refreshFolders();
          refreshTodos();
          countTodos();
        }
      });
      return false;
    }
  });

  //Delete todo from database
  function deleteTodo(elem) {
    var todo_id = $(elem).attr('id');
    var user_id = $('#user_id').val();
    $.ajax({
      url: 'src/delete-todo.php',
      type: 'GET',
      data: {
        'todo_id': todo_id,
        'user_id': user_id,
      },
      success: function(response){
        refreshTodos();
        refreshFolders();
        countTodos();
      }
    });
  };

  //Delete label from todo
  function deleteLabel(elem) {
    var todo_id = $(elem).attr('id');
    $.ajax({
      url: 'src/delete-label.php',
      type: 'GET',
      data: {
        'todo_id': todo_id,
      },
      success: function(response){
        refreshTodos();
        countTodos();
      }
    });
  };

  //Copy label
  function copyLabel(elem) {
    var label = $(elem).text();
    var color = $(elem).attr('id');
    $('#label_name').val(label);
    $('#gray').prop('checked', false);
    $('.' + color).prop('checked', true);
  }

  // Delete folder from database
  function deleteFolder(elem) {
    var folder_id = $(elem).attr('id');
    $.ajax({
      url: 'src/delete-folder.php',
      type: 'GET',
      data: {
        'folder_id': folder_id,
      },
      success: function(response){
        refreshFolders();
        refreshTodos();
        countTodos();
      }
    });
  }

  // Delete all completed todos
  function deleteCompleted() {
    var user_id = $('#user_id').val();
    $.ajax({
      url: 'src/delete-completed.php',
      type: 'GET',
      data: {
        'user_id': user_id,
      },
      success: function(response){
        refreshCompleted();
        countCompleted();
        clearAll();
      }
    });
  };

  //Edit todo into modal
  function editTodo(elem) {
    var todo_id = $(elem).attr('id');
    var todo_height = $(elem).outerHeight(true);
    $(elem).hide();
    var get_textarea = $("textarea[id=" + todo_id + "]");
    get_textarea.outerHeight(todo_height+10);
    get_textarea.show();
    $("button[id=" + todo_id + "]").show();
    // var get_todo_text = $(elem).text();
    // $('#editModal').modal();
    // $('#todo_id').val(todo_id);
    // $('#editBox').val(get_todo_text);
  };

  //Update todo
  function updateTodo(el){
    var todo_id = $(el).attr('id');
    var updated_todo = $("textarea[id=" + todo_id + "]").val();
    $.ajax({
      url: 'src/update-todo.php',
      type: 'POST',
      data: {
        'todo_id': todo_id,
        'updated_todo': updated_todo,
      },
      success: function(response){
        refreshTodos();
        $("textarea[id=" + todo_id + "]").hide();
        $("button[id=" + todo_id + "]").hide();
      }
    });
    return false;
  };

  //Dismiss update
  function dismiss(el) {
    var todo_id = $(el).attr('id');
    refreshTodos();
    $("input[id=" + todo_id + "]").hide();
    $("button[id=" + todo_id + "]").hide();
  }

  //Update todo
  // $('#save_todo_btn').click(function() {
  //   var todo_id = $('#todo_id').val();
  //   var updated_todo = $('#editBox').val();
  //   $.ajax({
  //     url: 'src/update-todo.php',
  //     type: 'POST',
  //     data: {
  //       'todo_id': todo_id,
  //       'updated_todo': updated_todo,
  //     },
  //     success: function(response){
  //       $('#editModal').modal('hide');
  //       refreshTodos();
  //     }
  //   });
  //   return false;
  // });

  //Check todo to completed
  function checkTodo(elem) {
    var todo_id = $(elem).attr('id');
    $.ajax({
      url: 'src/check-todo.php',
      type: 'GET',
      data: {
        'todo_id': todo_id,
      },
      success: function(response){
        refreshTodos();
        refreshCompleted();
        countTodos();
        countCompleted();
        clearAll();
        refreshFolders();
      }
    });
  };

  //Undo todo from completed
  function undoTodo(elem) {
    var todo_id = $(elem).attr('id');
    $.ajax({
      url: 'src/undo-todo.php',
      type: 'GET',
      data: {
        'todo_id': todo_id,
      },
      success: function(response){
        refreshTodos();
        refreshCompleted();
        countTodos();
        countCompleted();
        clearAll();
        refreshFolders();
      }
    });
  };

  //Add a color tag to the todo
  function tagTodo(elem) {
    var todo_id = $(elem).attr('id');
    var todo_tag = $(elem).attr('name');
    $.ajax({
      url: 'src/tag-todo.php',
      type: 'GET',
      data: {
        'todo_id': todo_id,
        'todo_tag': todo_tag,
      },
      success: function(response){
        refreshTodos();
      }
    });
  };

  //Move to Modal
  function movetoModal(elem) {
    $('#movetoFolderModal').modal();
    var user_id = $('#user_id').val();
    var todo_id = $('#todo-to-move').val($(elem).attr('id'));
    $.ajax({
      url: 'src/moveto-folders-list.php',
      type: 'GET',
      data: {
        'user_id': user_id,
      },
      success: function(response){
        $('#folders-list').html(response);
        refreshCompleted();
        countCompleted();
        clearAll();
      }
    });
  }

  //Move to folder
  function moveto(elem) {
    var folder_id = $(elem).attr('id');
    var todo_id = $('#todo-to-move').val();
    $.ajax({
      url: 'src/moveto-folder.php',
      type: 'GET',
      data: {
        'folder_id': folder_id,
        'todo_id': todo_id,
      },
      success: function(response){
        refreshCompleted();
        countCompleted();
        countTodos();
        refreshFolders();
        $('#movetoFolderModal').modal('hide');
      }
    });
  }
