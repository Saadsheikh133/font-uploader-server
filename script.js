"use strict";

const element = (selector) => {
    return document.querySelector(selector);
}

// :::::::::::::::::::::::: DIALOG BOX FOR GROUP CREATE :::::::::::::::::::::::: //
const showModal = (modalId) => {
    element(modalId).style.display = '';
    element('body').style.overflow = 'hidden';
}

const hideModal = (modalId) => {
    element(modalId).style.display = 'none';
    element('body').style.overflow = '';
}

const createGroupCreateFontTableRow = (data) => {
    const tr = document.createElement('tr');
    const fontFamily = data.font_name.split('.').slice(0, -1).join('.');

    // Create the <td> for font name
    const td_1 = document.createElement('td');
    td_1.textContent = fontFamily;

    // Create a <span> for font preview
    const span = document.createElement('span');
    span.style.fontFamily = fontFamily;
    span.textContent = fontFamily;

    // Create the <td> for font details
    const td_2 = document.createElement('td');
    td_2.appendChild(span);

    // Create a input checkbox
    const checkbox = document.createElement('input');
    checkbox.className = 'checkbox-group';
    checkbox.type = 'checkbox';
    checkbox.value = data.id;
    checkbox.title = 'Select for under the group';

    // Create the <td> for action
    const td_3 = document.createElement('td');
    td_3.className = 'action-opt';
    td_3.appendChild(checkbox);

    // Append all elements to the row
    tr.appendChild(td_1);
    tr.appendChild(td_2);
    tr.appendChild(td_3);

    return tr;
}

const displayGroupCreateFontTable = () => {
    const fontGroupCreateTableLoading = element('#fontGroupCreateTableLoading');
    const tbodyFontsGroupCreate = element('#tbodyFontsGroupCreate');

    fontGroupCreateTableLoading.style.display = '';
    tbodyFontsGroupCreate.innerHTML = '';

    fetch('ajax/fonts.php')
        .then(response => response.json())
        .then(data => {
            fontGroupCreateTableLoading.style.display = 'none';

            if (data.status === 'SUCCESS') {
                data.data.forEach(item => {
                    tbodyFontsGroupCreate.appendChild(createGroupCreateFontTableRow(item));
                });
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            alert(error);
        });
}

const createNewGroup = () => {
    const groupNameElement = element('#groupName');
    const groupName = groupNameElement.value.trim();
    const fontIdList = [];

    document.querySelectorAll('.checkbox-group').forEach(item => {
        if (item.checked) {
            fontIdList.push(item.value);
        }

        // The message is hidden when the font is selected
        item.addEventListener('input', function() {
            element('#groupCreateMessage').innerText = '';
        });
    });

    // Check Group Name
    if (groupName === '') {
        groupNameElement.style.borderColor = '#f44336';
        groupNameElement.focus();
    } else {
        groupNameElement.style.borderColor = '';
    }

    groupNameElement.addEventListener('input', () => {
        if (groupName === '') {
            groupNameElement.style.borderColor = '#f44336';
        } else {
            groupNameElement.style.borderColor = '';
        }
    });

    // Checking select font
    if (!fontIdList.length) {
        element('#groupCreateMessage').innerText = 'No font selected';
    } else {
        element('#groupCreateMessage').innerText = '';
    }

    // Create a new group
    if (fontIdList.length && groupName !== '') {
        element('#modalSave').disabled = true;
        element('#modalSave').style.opacity = '0.5';

        fetch('ajax/group-create.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({groupName: groupName, fontIdList: fontIdList})
        })
            .then(response => response.json())
            .then(data => {
                element('#modalSave').disabled = false;
                element('#modalSave').style.opacity = '';

                if (data.status === 'SUCCESS') {
                    hideModal('#modalCreateGroup');
                    displayFontGroupTable();
                } else {
                    element('#groupCreateMessage').innerText = data.message;
                }
            })
            .catch(error => {
                element('#groupCreateMessage').innerText = error;
            });
    }

}

// Create Group
element('#modalSave').addEventListener('click', () => {
    createNewGroup();
});

// Show Dialog
element('#createGroup').addEventListener('click', () => {
    showModal('#modalCreateGroup');
    element('#groupName').focus();
    element('#groupName').value = '';
    displayGroupCreateFontTable();
});

// Hide Dialog when 'X' button is clicked
element('#modalMainClose').addEventListener('click', () => {
    hideModal('#modalCreateGroup');
});

// Hide Dialog when 'Close' button is clicked
element('#modalClose').addEventListener('click', () => {
    hideModal('#modalCreateGroup');
});

// :::::::::::::::::::::::: SHOW FONT TABLE AND DELETE FONT :::::::::::::::::::::::: //
const deleteFont = (target) => {
    const row = target.closest('tr');
    row.style.background = '#fae9e9';

    target.disabled = true;
    target.style.opacity = '0.5';
    target.style.cursor = 'wait';

    fetch('ajax/font-delete.php?id=' + target.value, {
        method: 'DELETE'
    })
        .then(response => {
            target.disabled = false;
            row.style.background = '';

            if (response.ok) {
                row.remove();
            } else {
                alert('Error deleting font: ' + response.statusText);
            }
        })
        .catch(error => {
            alert('Error: ' + error);
        });
}

const confirmDelete = (target) => {
    showModal('#modalDelete');

    element('#modalMainCloseDelete').addEventListener('click', () => {
        hideModal('#modalDelete');
    });

    element('#modalCloseDelete').addEventListener('click', () => {
        hideModal('#modalDelete');
    });

    element('#modalDeleteConfirm').addEventListener('click', () => {
        deleteFont(target);
        hideModal('#modalDelete');
    });
}

const createFontTableRow = (data) => {
    const tr = document.createElement('tr');
    const fontFamily = data.font_name.split('.').slice(0, -1).join('.');

    // Create the <td> for font name
    const td_1 = document.createElement('td');
    td_1.textContent = fontFamily;

    // Create the <style> element for @font-face
    const style = document.createElement('style');
    style.innerHTML = `@font-face {
        font-family: ${fontFamily};
        src: url(uploads/${data.font_name});
    }`;

    // Create a <span> for font preview
    const span = document.createElement('span');
    span.style.fontFamily = fontFamily;
    span.textContent = fontFamily;

    // Create the <td> for font details
    const td_2 = document.createElement('td');
    td_2.appendChild(style);
    td_2.appendChild(span);

    // Create a delete button
    const button = document.createElement('button');
    button.className = 'delete-btn';
    button.value = data.id;
    button.title = 'Delete';
    button.innerHTML = '&#10005;';
    button.addEventListener('click', (e) => {
        confirmDelete(e.target)
    });

    // Create the <td> for action
    const td_3 = document.createElement('td');
    td_3.className = 'action-opt';
    td_3.appendChild(button);

    // Append all elements to the row
    tr.appendChild(td_1);
    tr.appendChild(td_2);
    tr.appendChild(td_3);

    return tr;
}

const displayFontTable = () => {
    const fontTableLoading = element('#fontTableLoading');
    const tbodyFonts = element('#tbodyFonts');

    fontTableLoading.style.display = '';

    fetch('ajax/fonts.php')
        .then(response => response.json())
        .then(data => {
            fontTableLoading.style.display = 'none';

            if (data.status === 'SUCCESS') {
                tbodyFonts.innerHTML = '';
                data.data.forEach(item => {
                    tbodyFonts.appendChild(createFontTableRow(item));
                });
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            alert(error);
        });
}

// Call the function to display the font table
displayFontTable();

// :::::::::::::::::::::::: SHOW GROUP TABLE :::::::::::::::::::::::: //
const deleteFontGroup = (target) => {
    const row = target.closest('tr');
    row.style.background = '#fae9e9';

    target.disabled = true;
    target.style.opacity = '0.5';
    target.style.cursor = 'wait';

    fetch('ajax/group-delete.php?id=' + target.value, {
        method: 'DELETE'
    })
        .then(response => {
            target.disabled = false;
            row.style.background = '';

            if (response.ok) {
                row.remove();
            } else {
                alert('Error deleting font: ' + response.statusText);
            }
        })
        .catch(error => {
            alert('Error: ' + error);
        });
}

const confirmDeleteGroup = (target) => {
    showModal('#modalDelete');

    element('#modalMainCloseDelete').addEventListener('click', () => {
        hideModal('#modalDelete');
    });

    element('#modalCloseDelete').addEventListener('click', () => {
        hideModal('#modalDelete');
    });

    element('#modalDeleteConfirm').addEventListener('click', () => {
        deleteFontGroup(target);
        hideModal('#modalDelete');
    });
}

const createFontGroupTableRow = (data) => {
    const tr = document.createElement('tr');

    // Create the <td> for font name
    const td_1 = document.createElement('td');
    td_1.textContent = data.group_name;

    // Create the <td> for font details
    const td_2 = document.createElement('td');
    td_2.textContent = data.fonts;


    // Create a delete button
    const deleteBtn = document.createElement('button');
    deleteBtn.className = 'delete-btn';
    deleteBtn.value = data.group_id;
    deleteBtn.title = 'Delete';
    deleteBtn.innerHTML = '&#10005;';
    deleteBtn.addEventListener('click', (e) => {
        confirmDeleteGroup(e.target);
    });

    // Create a edit button
    const editBtn = document.createElement('button');
    editBtn.className = 'edit-btn';
    editBtn.value = data.group_id;
    editBtn.title = 'Edit';
    editBtn.innerHTML = '&#9998;';
    editBtn.addEventListener('click', () => {
        alert('This module is under construction');
    });

    // Create the <td> for action
    const td_3 = document.createElement('td');
    td_3.className = 'action-opt';
    td_3.appendChild(editBtn);
    td_3.appendChild(deleteBtn);

    // Append all elements to the row
    tr.appendChild(td_1);
    tr.appendChild(td_2);
    tr.appendChild(td_3);

    return tr;
}

const displayFontGroupTable = () => {
    const fontTableLoading = element('#fontGroupTableLoading');
    const tbodyFontsGroup = element('#tbodyFontsGroup');

    fontTableLoading.style.display = '';

    fetch('ajax/groups.php')
        .then(response => response.json())
        .then(data => {
            fontTableLoading.style.display = 'none';

            if (data.status === 'SUCCESS') {
                tbodyFontsGroup.innerHTML = '';
                data.data.forEach(item => {
                    tbodyFontsGroup.appendChild(createFontGroupTableRow(item));
                });
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            alert(error);
        });
}

// Call the function to display the font group table
displayFontGroupTable();

// :::::::::::::::::::::::: FILE UPLOAD :::::::::::::::::::::::: //
const createProgressBar = (filename) => {
    const progressBar = document.createElement('div');
    progressBar.className = 'progress-bar';
    progressBar.style.width = '0%';
    progressBar.textContent = 'Uploading ' + filename;

    const progress = document.createElement('div');
    progress.className = 'progress';
    progress.title = 'Click to remove';
    progress.addEventListener('click', () => {
        progress.remove();
    });
    progress.appendChild(progressBar);

    return progress;
}

const updateProgressBar = (progressBar, percent) => {
    progressBar.lastChild.style.width = percent + '%';
    progressBar.lastChild.textContent = percent.toFixed(2) + '%';
}

const uploadFile = (files) => {
    const formData = new FormData();

    for (const file of files) {
        formData.append('file', file);

        const progressBar = createProgressBar(file.name);
        element('.upload-progress').appendChild(progressBar);

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'ajax/upload.php', true);

        xhr.upload.addEventListener('progress', (e) => {
            if (e.lengthComputable) {
                const percent = (e.loaded / e.total) * 100;
                updateProgressBar(progressBar, percent);
            }
        });

        xhr.onreadystatechange = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    const result = JSON.parse(xhr.responseText);
                    if (result.status === 'SUCCESS') {
                        progressBar.lastChild.textContent = result.message;
                        progressBar.lastChild.classList.add('progress-bar-success');
                        displayFontTable();
                    } else {
                        progressBar.lastChild.textContent = result.message;
                        progressBar.lastChild.classList.add('progress-bar-error');
                    }
                } else {
                    progressBar.lastChild.textContent = 'Error uploading';
                    progressBar.lastChild.classList.add('progress-bar-error');
                }
            }
        }

        xhr.send(formData);
    }
}

// File Upload
element('#files').addEventListener('change', (e) => {
    uploadFile(e.target.files);
});