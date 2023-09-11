<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Font Uploader & Grouping</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- File Upload -->
    <div class="main">
        <div class="drop-zone">
            <input type="file" id="files" multiple />
            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACMAAAAjCAYAAAAe2bNZAAAACXBIWXMAAAsTAAALEwEAmpwYAAACHUlEQVR4nO3WT4hOURjH8c9MTBkhZaIwYoFSLK6kKUUWyJI1hqSwMSlSktI0iZ0Fk438SWqKWLCWFJJmlFhIbPxJyZ8w/ozu9Ey9M80773vvnZc086vT7Z57nud873POeZ7DuMaIJmMLzuEO7uMGOrDyb0HUYTfe4yceBFAnruI1+nAby2sJ0oCugDiF5mHG1GMdHuIbttUK5jI+YG0VYyfiNH5jc5FJ52EX2rAeE7ADP7A645JexGfMyQpRj+MxaV84SZ9P8AYnsjrElLA9m9WwA704jOnRtwjX8Qkz5dNBfEFjtQZzIyIHynwfgMujhRHhDdUa7AyYSUZf6d75Himh4sDteI4etVOaf46NNKAxsma6T85jcQ1hXsRSvcTRyOCDdAUfsUbtNRUrcAhv8RTzBz5uDNK8CakJF+KZVbPwCI8H9ui1KG51OUG642e6cwItiHKxT4TqSAGQ3oDpLQB0CffEUduTE+QdWgOmNd7zALVFMvUK7RmNO2PiZUgCJon3tP9MRn/7o/D2F7CejHtmdknBK4UR/en3LOqKi5lV4SxNeHmUDIHJqiWR8feWhv1rzuOdFIBJT9KzWJn0wtavhsgVqdOb2IqWmGBoWzpkSYeDqYtxSZmW3o1OxqYdlPRKHWzCXfyKCcq1lgowLRXs+6JGtUdGHlHTYi3LRUbByDTHBW7UlRTcwKOqZBzmf4hME25hxr8GGdfY0x+LS5NAgVTSDgAAAABJRU5ErkJggg==" alt="Download Icon">
            <small><strong>Click to upload</strong> or drag and drop</small>
            <small class="allowed">Only TTF File Allowed</small>
        </div>

        <div class="upload-progress">
            <!-- For JS Response -->
        </div>
    </div>

    <!-- List of Uploaded Fonts -->
    <div class="main">
        <h3 class="title">List of Uploaded Fonts</h3>
        <table>
            <thead>
                <tr>
                    <th>Font Name</th>
                    <th>Preview</th>
                    <th class="action">Action</th>
                </tr>
                <tr id="fontTableLoading" style="display: none;">
                    <td colspan="3">Loading...</td>
                </tr>
            </thead>

            <tbody id="tbodyFonts">
               <!-- For JS Response -->
            </tbody>
        </table>
    </div>

    <!-- List of All Groups -->
    <div class="main">
        <h3 class="title">List of All Groups</h3>
        <button class="create-group" id="createGroup" title="Create a Group">+</button>
        <table>
            <thead>
            <tr>
                <th>Group Name</th>
                <th>Fonts</th>
                <th class="action">Action</th>
            </tr>
            <tr id="fontGroupTableLoading" style="display: none;">
                <td colspan="3">Loading...</td>
            </tr>
            </thead>

            <tbody id="tbodyFontsGroup">
                <!-- For JS Response -->
            </tbody>
        </table>
    </div>

    <!-- Modal Dialog -->
    <div class="modal" id="modalCreateGroup" style="display: none">
        <div class="modal-dialog">
            <div class="modal-header">
                <h3 class="modal-title">Create a Group</h3>
                <button id="modalMainClose">&#10005;</button>
            </div>
            <div class="modal-body">
                <div class="group-name">
                    <label for="groupName">
                        <input type="text" id="groupName" placeholder="New Name" autofocus>
                    </label>
                </div>

                <table>
                    <thead>
                    <tr>
                        <th>Font Name</th>
                        <th>Preview</th>
                        <th class="action">Action</th>
                    </tr>
                    <tr id="fontGroupCreateTableLoading" style="display: none;">
                        <td colspan="3">Loading...</td>
                    </tr>
                    </thead>

                    <tbody id="tbodyFontsGroupCreate">
                        <!-- For JS Response -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <span id="groupCreateMessage"><!-- For JS Response --></span>
                <button id="modalClose">Close</button>
                <button id="modalSave">Save</button>
            </div>
        </div>
    </div>


    <div class="modal" id="modalDelete" style="display: none;">
        <div class="modal-dialog modal-sm">
            <div class="modal-header">
                <h3 class="modal-title">Confirm Delete</h3>
                <button id="modalMainCloseDelete">&#10005;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the font? You are not recovery font if you delete.</p>
            </div>
            <div class="modal-footer">
                <button id="modalCloseDelete">Close</button>
                <button id="modalDeleteConfirm">Confirm</button>
            </div>
        </div>
    </div>
<script src="script.js"></script>
</body>
</html>