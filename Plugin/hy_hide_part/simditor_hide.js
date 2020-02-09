
    

(function (root, factory) {
  if (typeof define === 'function' && define.amd) {
    // AMD. Register as an anonymous module unless amdModuleId is set
    define('simditor-hide', ["jquery","simditor"], function (a0,b1) {
      return (root['SimditorHide'] = factory(a0,b1));
    });
  } else if (typeof exports === 'object') {
    // Node. Does not work with strict CommonJS, but
    // only CommonJS-like environments that support module.exports,
    // like Node.
    module.exports = factory(require("jquery"),require("simditor"));
  } else {
    root['SimditorHide'] = factory(jQuery,Simditor);
  }
}(this, function ($, Simditor) {

var SimditorHide,
  extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
  hasProp = {}.hasOwnProperty;

HideButton = (function(superClass) {
  extend(HideButton, superClass);

  function HideButton() {
    return HideButton.__super__.constructor.apply(this, arguments);
  }

  HideButton.prototype.name = 'hide';

  HideButton.prototype.icon = 'hide';

  HideButton.prototype.htmlTag = 'hide';

  HideButton.prototype.disableTag = 'pre, table';
  HideButton.prototype._init = function() {
    this.title ='隐藏部分内容';
    Simditor.Util.prototype.blockNodes.push('hide');
    return HideButton.__super__._init.call(this);
  };

  HideButton.prototype.command = function() {
    var $hr, $newBlock, $nextBlock, $rootBlock;
    $rootBlock = this.editor.selection.rootNodes().first();
    $nextBlock = $rootBlock.next();
    if ($nextBlock.length > 0) {
      this.editor.selection.save();
    } else {
      $newBlock = $('<p/>').append(this.editor.util.phBr);
    }
    $hr = $('<p>[hide]隐藏内容[/hide]</p>').insertAfter($rootBlock);
    if ($newBlock) {
      $newBlock.insertAfter($hr);
      this.editor.selection.setRangeAtStartOf($newBlock);
    } else {
      this.editor.selection.restore();
    }
    return this.editor.trigger('valuechanged');
  };


  return HideButton;

})(Simditor.Button);

Simditor.Toolbar.addButton(HideButton);

return SimditorMark;

}));