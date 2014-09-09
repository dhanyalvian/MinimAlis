<div class="row-panel">
    <div class="heading_title">
        Basic Example
    </div>
    
    <form role="form" action="#">
        <div class="row-panel ">
            <div class="col-md-6 panel-left">
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
                    <label for="input-file">File input</label>
                    <input type="file" id="input-file">
                    <p class="help-block">Example block-level help text here.</p>
                </div>
            </div>

            <div class="col-md-6 panel-right">
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

                <div class="row-panel">
                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                    <button type="reset" class="btn btn-default btn-sm">Reset</button>
                </div>
            </div>
            
            <div class="clearfix"></div>
        </div>
    </form>
</div>

<div class="row-panel">
    <div class="heading_title">
        Inline Form
    </div>
    
    <form class="form-inline" role="form" action="#">
        <div class="form-group">
            <label class="sr-only" for="exampleInputEmail2">Email address</label>
            <input type="email" class="form-control" id="exampleInputEmail2" placeholder="Enter email">
        </div>
  
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon">@</div>
                <input class="form-control" type="email" placeholder="Enter email">
            </div>
        </div>
  
        <div class="form-group">
            <label class="sr-only" for="exampleInputPassword2">Password</label>
            <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Password">
        </div>
    
        <div class="checkbox">
            <label>
                <input type="checkbox"> Remember me
            </label>
        </div>
  
        <button type="submit" class="btn btn-default btn-sm">Sign in</button>
    </form>
</div>

<div class="row-panel">
    <div class="heading_title">
        Horizontal Form
    </div>
    
    <form class="form-horizontal" role="form" action="#">
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="inputEmail3" placeholder="Email">
            </div>
        </div>
  
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
            </div>
        </div>
    
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                    <label>
                        <input type="checkbox"> Remember me
                    </label>
                </div>
            </div>
        </div>
    
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default btn-sm">Sign in</button>
            </div>
        </div>
    </form>
</div>

<div class="row-panel">
    <div class="heading_title">
        Static Control
    </div>
    
    <form class="form-horizontal" role="form" action="#">
        <div class="form-group">
            <label class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10">
                <p class="form-control-static">email@example.com</p>
            </div>
        </div>
  
        <div class="form-group">
            <label for="inputPassword" class="col-sm-2 control-label">Password</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="inputPassword" placeholder="Password">
            </div>
        </div>
    </form>
</div>
    
<div class="row-panel">
    <div class="heading_title">
        Disabled Fieldsets
    </div>
    
    <form role="form" action="#">
        <fieldset disabled>
            <div class="form-group">
                <label for="disabledTextInput">Disabled input</label>
                <input type="text" id="disabledTextInput" class="form-control" placeholder="Disabled input">
            </div>
    
            <div class="form-group">
                <label for="disabledSelect">Disabled select menu</label>
                <select id="disabledSelect" class="form-control">
                    <option>Disabled select</option>
                </select>
            </div>
    
            <div class="checkbox">
                <label>
                    <input type="checkbox"> Can't check this
                </label>
            </div>
    
            <button type="submit" class="btn btn-primary btn-sm">Submit</button>
        </fieldset>
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
    
    <form role="form" action="#">
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

<div class="row-panel">
    <div class="heading_title">
        Control sizing
    </div>
    
    <form role="form">
        <div class="form-group">
            <input class="form-control input-lg" type="text" placeholder=".input-lg">
        </div>
        
        <div class="form-group">
            <input class="form-control" type="text" placeholder="Default input">
        </div>
        
        <div class="form-group">
            <input class="form-control input-sm" type="text" placeholder=".input-sm">
        </div>

        <div class="form-group">
            <select class="form-control input-lg">
                <option>.input-lg</option>
            </select>
        </div>
            
        <div class="form-group">
            <select class="form-control">
                <option>Default select</option>
            </select>
        </div>
        
        <div class="form-group">
            <select class="form-control input-sm">
                <option>.input-sm</option>
            </select>
        </div>
    </form>
</div>

<div class="row-panel">
    <div class="heading_title">
        Buttons
    </div>
    
    <form role="form" action="#">
        <!-- Standard button -->
        <button type="button" class="btn btn-default btn-sm">Default</button>

        <!-- Provides extra visual weight and identifies the primary action in a set of buttons -->
        <button type="button" class="btn btn-primary btn-sm">Primary</button>

        <!-- Indicates a successful or positive action -->
        <button type="button" class="btn btn-success btn-sm">Success</button>

        <!-- Contextual button for informational alert messages -->
        <button type="button" class="btn btn-info btn-sm">Info</button>

        <!-- Indicates caution should be taken with this action -->
        <button type="button" class="btn btn-warning btn-sm">Warning</button>

        <!-- Indicates a dangerous or potentially negative action -->
        <button type="button" class="btn btn-danger btn-sm">Danger</button>

        <!-- Deemphasize a button by making it look like a link while maintaining button behavior -->
        <button type="button" class="btn btn-link btn-sm">Link</button>
    </form>
</div>
