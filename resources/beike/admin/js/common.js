export default {
   fileManagerIframe(callback) {
    const base = document.querySelector('base').href;

    layer.open({
      type: 2,
      title: '图片管理器',
      shadeClose: false,
      skin: 'file-manager-box',
      scrollbar: false,
      shade: 0.4,
      area: ['1060px', '680px'],
      content: `${base}/file_manager`,
      success: function(layerInstance, index) {
        var iframeWindow = window[layerInstance.find("iframe")[0]["name"]];
        iframeWindow.callback = function(images) {
          callback(images);
        }
      }
    });
  },

  debounce(fn, delay) {
    var timeout = null; // 创建一个标记用来存放定时器的返回值

    return function (e) {
      // 每当用户输入的时候把前一个 setTimeout clear 掉
      clearTimeout(timeout);
      // 然后又创建一个新的 setTimeout, 这样就能保证interval 间隔内如果时间持续触发，就不会执行 fn 函数
      timeout = setTimeout(() => {
          fn.apply(this, arguments);
      }, delay);
    }
  },

  randomString(length) {
    let str = '';
    for (; str.length < length; str += Math.random().toString(36).substr(2));
    return str.substr(0, length);
  },
}