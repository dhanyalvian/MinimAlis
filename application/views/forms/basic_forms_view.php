<div class="row-panel">
    <div class="heading_title">
        Form Elements
    </div>
    
    <form role="form" action="#">
        <div class="form-group">
            <label for="input-text">Text</label>
            <input type="email" class="form-control" id="input-text" placeholder="Text" />
        </div>

        <div class="form-group">
            <label for="input-email">Email address</label>
            <input type="email" class="form-control" id="input-email" placeholder="Enter email" />
        </div>

        <div class="form-group">
            <label for="input-password">Password</label>
            <input type="password" class="form-control" id="input-password" placeholder="Password" />
        </div>

        <div class="form-group">
            <label for="textarea">Textarea</label>
            <textarea class="form-control" id="textarea" rows="3"></textarea>
        </div>

        <div class="form-group">
            <label for="input-select">Select</label>
            <select class="form-control" id="input-select">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
            </select>
        </div>

        <div class="form-group">
            <label for="input-select-multiple">Select (Multiple)</label>
            <select multiple class="form-control" id="input-select-multiple">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
            </select>
        </div>

        <div class="form-group">
            <label for="input-file">File input</label>
            <input type="file" id="input-file">
            <p class="help-block">Example block-level help text here.</p>
        </div>

        <div class="row-panel">
            <label>Checkbox (stacked)</label>
            <div class="checkbox">
                <label><input type="checkbox" /> Option 1</label>
            </div>
            <div class="checkbox">
                <label><input type="checkbox" /> Option 2</label>
            </div>
        </div>

        <div class="row-panel">
            <label>Radio (stacked)</label>
            <div class="radio">
                <label><input type="radio" name="radio" /> Option 1</label>
            </div>
            <div class="radio">
                <label><input type="radio" name="radio" /> Option 2</label>
            </div>
        </div>

        <div class="row-panel btn-theme">
            <button type="submit" class="btn btn-default btn-sm">Submit</button>
        </div>
    </form>
</div>

<div class="row-panel">
    <div class="heading_title">
        Validations
    </div>
    
    <form role="form">
        <div class="form-group has-success">
            <input type="text" class="form-control" id="textInput" placeholder="Text Input" />
            <span class="help-block">Success</span>
        </div>

        <div class="form-group has-warning">
            <input type="text" class="form-control" id="textInput" placeholder="Text Input" />
            <span class="help-block">Warning</span>
        </div>

        <div class="form-group has-error">
            <input type="text" class="form-control" id="textInput" placeholder="Text Input" />
            <span class="help-block">Error</span>
        </div>

        <div class="has-error">
            <div class="radio">
                <label class="checkbox">
                    <input type="checkbox" id="checkboxError" value="option1">
                    Option one is this and that&mdash;be sure to include why it's great
                </label>
            </div>
        </div>

        <div class="has-success">
            <div class="radio">
                <label>
                    <input type="radio" name="optionsRadios" id="radiosSuccess1" value="option1" checked>
                    Option one is this and that&mdash;be sure to include why it's great
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="optionsRadios" id="radiosSuccess2" value="option2">
                    Option two can be something else and selecting it will deselect option one
                </label>
            </div>
        </div>
    </form>
</div>

<div class="row-panel">
    <div class="heading_title">
        With optional icons
    </div>
    
    <form role="form">
        <div class="form-group has-success has-feedback">
            <label class="control-label" for="inputSuccess2">Input with success</label>
            <input type="text" class="form-control" id="inputSuccess2">
            <span class="glyphicon glyphicon-ok form-control-feedback"></span>
        </div>
        
        <div class="form-group has-warning has-feedback">
            <label class="control-label" for="inputWarning2">Input with warning</label>
            <input type="text" class="form-control" id="inputWarning2">
            <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
        </div>
        
        <div class="form-group has-error has-feedback">
            <label class="control-label" for="inputError2">Input with error</label>
            <input type="text" class="form-control" id="inputError2">
            <span class="glyphicon glyphicon-remove form-control-feedback"></span>
        </div>
    </form>
</div>
