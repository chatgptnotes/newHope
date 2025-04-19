/*!
 * jQuery.selection - jQuery Plugin
 *
 * Copyright (c) 2010-2012 IWASAKI Koji (@madapaja).
 * http://blog.madapaja.net/
 * Under The MIT License
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */
(function($, win, doc) {
    /**
     * Ã¨Â¦Â�Ã§Â´ Ã£Â�Â®Ã¦â€“â€¡Ã¥Â­â€”Ã¥Ë†â€”Ã©Â�Â¸Ã¦Å Å¾Ã§Å Â¶Ã¦â€¦â€¹Ã£â€šâ€™Ã¥Â�â€“Ã¥Â¾â€”Ã£Â�â€”Ã£Â�Â¾Ã£Â�â„¢
     *
     * @param   {Element}   element         Ã¥Â¯Â¾Ã¨Â±Â¡Ã¨Â¦Â�Ã§Â´ 
     * @return  {Object}    return
     * @return  {String}    return.text     Ã©Â�Â¸Ã¦Å Å¾Ã£Â�â€¢Ã£â€šÅ’Ã£Â�Â¦Ã£Â�â€žÃ£â€šâ€¹Ã¦â€“â€¡Ã¥Â­â€”Ã¥Ë†â€”
     * @return  {Integer}   return.start    Ã©Â�Â¸Ã¦Å Å¾Ã©â€“â€¹Ã¥Â§â€¹Ã¤Â½Â�Ã§Â½Â®
     * @return  {Integer}   return.end      Ã©Â�Â¸Ã¦Å Å¾Ã§Âµâ€šÃ¤Âºâ€ Ã¤Â½Â�Ã§Â½Â®
     */
    var _getCaretInfo = function(element){
        var res = {
            text: '',
            start: 0,
            end: 0
        };

        if (!element.value) {
            /* Ã¥â‚¬Â¤Ã£Â�Å’Ã£Â�ÂªÃ£Â�â€žÃ£â‚¬Â�Ã£â€šâ€šÃ£Â�â€”Ã£Â�Â�Ã£Â�Â¯Ã§Â©ÂºÃ¦â€“â€¡Ã¥Â­â€”Ã¥Ë†â€” */
            return res;
        }

        try {
            if (win.getSelection) {
                /* IE Ã¤Â»Â¥Ã¥Â¤â€“ */
                res.start = element.selectionStart;
                res.end = element.selectionEnd;
                res.text = element.value.slice(res.start, res.end);
            } else if (doc.selection) {
                /* for IE */
                element.focus();

                var range = doc.selection.createRange(),
                    range2 = doc.body.createTextRange(),
                    tmpLength;

                res.text = range.text;

                try {
                    range2.moveToElementText(element);
                    range2.setEndPoint('StartToStart', range);
                } catch (e) {
                    range2 = element.createTextRange();
                    range2.setEndPoint('StartToStart', range);
                }

                res.start = element.value.length - range2.text.length;
                res.end = res.start + range.text.length;
            }
        } catch (e) {
            /* Ã£Â�â€šÃ£Â�Â�Ã£â€šâ€°Ã£â€šÂ�Ã£â€šâ€¹ */
        }

        return res;
    };

    /**
     * Ã¨Â¦Â�Ã§Â´ Ã£Â�Â«Ã¥Â¯Â¾Ã£Â�â„¢Ã£â€šâ€¹Ã£â€šÂ­Ã£Æ’Â£Ã£Æ’Â¬Ã£Æ’Æ’Ã£Æ’Ë†Ã¦â€œÂ�Ã¤Â½Å“
     * @type {Object}
     */
    var _CaretOperation = {
        /**
         * Ã¨Â¦Â�Ã§Â´ Ã£Â�Â®Ã£â€šÂ­Ã£Æ’Â£Ã£Æ’Â¬Ã£Æ’Æ’Ã£Æ’Ë†Ã¤Â½Â�Ã§Â½Â®Ã£â€šâ€™Ã¥Â�â€“Ã¥Â¾â€”Ã£Â�â€”Ã£Â�Â¾Ã£Â�â„¢
         *
         * @param   {Element}   element         Ã¥Â¯Â¾Ã¨Â±Â¡Ã¨Â¦Â�Ã§Â´ 
         * @return  {Object}    return
         * @return  {Integer}   return.start    Ã©Â�Â¸Ã¦Å Å¾Ã©â€“â€¹Ã¥Â§â€¹Ã¤Â½Â�Ã§Â½Â®
         * @return  {Integer}   return.end      Ã©Â�Â¸Ã¦Å Å¾Ã§Âµâ€šÃ¤Âºâ€ Ã¤Â½Â�Ã§Â½Â®
         */
        getPos: function(element) {
            var tmp = _getCaretInfo(element);
            return {start: tmp.start, end: tmp.end};
        },

        /**
         * Ã¨Â¦Â�Ã§Â´ Ã£Â�Â®Ã£â€šÂ­Ã£Æ’Â£Ã£Æ’Â¬Ã£Æ’Æ’Ã£Æ’Ë†Ã¤Â½Â�Ã§Â½Â®Ã£â€šâ€™Ã¨Â¨Â­Ã¥Â®Å¡Ã£Â�â€”Ã£Â�Â¾Ã£Â�â„¢
         *
         * @param   {Element}   element         Ã¥Â¯Â¾Ã¨Â±Â¡Ã¨Â¦Â�Ã§Â´ 
         * @param   {Object}    toRange         Ã¨Â¨Â­Ã¥Â®Å¡Ã£Â�â„¢Ã£â€šâ€¹Ã£â€šÂ­Ã£Æ’Â£Ã£Æ’Â¬Ã£Æ’Æ’Ã£Æ’Ë†Ã¤Â½Â�Ã§Â½Â®
         * @param   {Integer}   toRange.start   Ã©Â�Â¸Ã¦Å Å¾Ã©â€“â€¹Ã¥Â§â€¹Ã¤Â½Â�Ã§Â½Â®
         * @param   {Integer}   toRange.end     Ã©Â�Â¸Ã¦Å Å¾Ã§Âµâ€šÃ¤Âºâ€ Ã¤Â½Â�Ã§Â½Â®
         * @param   {String}    caret           Ã£â€šÂ­Ã£Æ’Â£Ã£Æ’Â¬Ã£Æ’Æ’Ã£Æ’Ë†Ã£Æ’Â¢Ã£Æ’Â¼Ã£Æ’â€° "keep" | "start" | "end" Ã£Â�Â®Ã£Â�â€žÃ£Â�Å¡Ã£â€šÅ’Ã£Â�â€¹
         */
        setPos: function(element, toRange, caret) {
            caret = this._caretMode(caret);

            if (caret == 'start') {
                toRange.end = toRange.start;
            } else if (caret == 'end') {
                toRange.start = toRange.end;
            }

            element.focus();
            try {
                if (element.createTextRange) {
                    var range = element.createTextRange();

                    if (win.navigator.userAgent.toLowerCase().indexOf("msie") >= 0) {
                        toRange.start = element.value.substr(0, toRange.start).replace(/\r/g, '').length;
                        toRange.end = element.value.substr(0, toRange.end).replace(/\r/g, '').length;
                    }

                    range.collapse(true);
                    range.moveStart('character', toRange.start);
                    range.moveEnd('character', toRange.end - toRange.start);

                    range.select();
                } else if (element.setSelectionRange) {
                    element.setSelectionRange(toRange.start, toRange.end);
                }
            } catch (e) {
                /* Ã£Â�â€šÃ£Â�Â�Ã£â€šâ€°Ã£â€šÂ�Ã£â€šâ€¹ */
            }
        },

        /**
         * Ã¨Â¦Â�Ã§Â´ Ã¥â€ â€¦Ã£Â�Â®Ã©Â�Â¸Ã¦Å Å¾Ã¦â€“â€¡Ã¥Â­â€”Ã¥Ë†â€”Ã£â€šâ€™Ã¥Â�â€“Ã¥Â¾â€”Ã£Â�â€”Ã£Â�Â¾Ã£Â�â„¢
         *
         * @param   {Element}   element         Ã¥Â¯Â¾Ã¨Â±Â¡Ã¨Â¦Â�Ã§Â´ 
         * @return  {String}    return          Ã©Â�Â¸Ã¦Å Å¾Ã¦â€“â€¡Ã¥Â­â€”Ã¥Ë†â€”
         */
        getText: function(element) {
            return _getCaretInfo(element).text;
        },

        /**
         * Ã£â€šÂ­Ã£Æ’Â£Ã£Æ’Â¬Ã£Æ’Æ’Ã£Æ’Ë†Ã£Æ’Â¢Ã£Æ’Â¼Ã£Æ’â€°Ã£â€šâ€™Ã©Â�Â¸Ã¦Å Å¾Ã£Â�â€”Ã£Â�Â¾Ã£Â�â„¢
         *
         * @param   {String}    caret           Ã£â€šÂ­Ã£Æ’Â£Ã£Æ’Â¬Ã£Æ’Æ’Ã£Æ’Ë†Ã£Æ’Â¢Ã£Æ’Â¼Ã£Æ’â€°
         * @return  {String}    return          "keep" | "start" | "end" Ã£Â�Â®Ã£Â�â€žÃ£Â�Å¡Ã£â€šÅ’Ã£Â�â€¹
         */
        _caretMode: function(caret) {
            caret = caret || "keep";
            if (caret == false) {
                caret = 'end';
            }

            switch (caret) {
                case 'keep':
                case 'start':
                case 'end':
                    break;

                default:
                    caret = 'keep';
            }

            return caret;
        },

        /**
         * Ã©Â�Â¸Ã¦Å Å¾Ã¦â€“â€¡Ã¥Â­â€”Ã¥Ë†â€”Ã£â€šâ€™Ã§Â½Â®Ã£Â�Â�Ã¦Â�â€ºÃ£Â�Ë†Ã£Â�Â¾Ã£Â�â„¢
         *
         * @param   {Element}   element         Ã¥Â¯Â¾Ã¨Â±Â¡Ã¨Â¦Â�Ã§Â´ 
         * @param   {String}    text            Ã§Â½Â®Ã£Â�Â�Ã¦Â�â€ºÃ£Â�Ë†Ã£â€šâ€¹Ã¦â€“â€¡Ã¥Â­â€”Ã¥Ë†â€”
         * @param   {String}    caret           Ã£â€šÂ­Ã£Æ’Â£Ã£Æ’Â¬Ã£Æ’Æ’Ã£Æ’Ë†Ã£Æ’Â¢Ã£Æ’Â¼Ã£Æ’â€° "keep" | "start" | "end" Ã£Â�Â®Ã£Â�â€žÃ£Â�Å¡Ã£â€šÅ’Ã£Â�â€¹
         */
        replace: function(element, text, caret) {
            var tmp = _getCaretInfo(element),
                orig = element.value,
                pos = $(element).scrollTop(),
                range = {start: tmp.start, end: tmp.start + text.length};

            element.value = orig.substr(0, tmp.start) + text + orig.substr(tmp.end);

            $(element).scrollTop(pos);
            this.setPos(element, range, caret);
        },

        /**
         * Ã¦â€“â€¡Ã¥Â­â€”Ã¥Ë†â€”Ã£â€šâ€™Ã©Â�Â¸Ã¦Å Å¾Ã¦â€“â€¡Ã¥Â­â€”Ã¥Ë†â€”Ã£Â�Â®Ã¥â€°Â�Ã£Â�Â«Ã¦Å’Â¿Ã¥â€¦Â¥Ã£Â�â€”Ã£Â�Â¾Ã£Â�â„¢
         *
         * @param   {Element}   element         Ã¥Â¯Â¾Ã¨Â±Â¡Ã¨Â¦Â�Ã§Â´ 
         * @param   {String}    text            Ã¦Å’Â¿Ã¥â€¦Â¥Ã¦â€“â€¡Ã¥Â­â€”Ã¥Ë†â€”
         * @param   {String}    caret           Ã£â€šÂ­Ã£Æ’Â£Ã£Æ’Â¬Ã£Æ’Æ’Ã£Æ’Ë†Ã£Æ’Â¢Ã£Æ’Â¼Ã£Æ’â€° "keep" | "start" | "end" Ã£Â�Â®Ã£Â�â€žÃ£Â�Å¡Ã£â€šÅ’Ã£Â�â€¹
         */
        insertBefore: function(element, text, caret) {
            var tmp = _getCaretInfo(element),
                orig = element.value,
                pos = $(element).scrollTop(),
                range = {start: tmp.start + text.length, end: tmp.end + text.length};

            element.value = orig.substr(0, tmp.start) + text + orig.substr(tmp.start);

            $(element).scrollTop(pos);
            this.setPos(element, range, caret);
        },

        /**
         * Ã¦â€“â€¡Ã¥Â­â€”Ã¥Ë†â€”Ã£â€šâ€™Ã©Â�Â¸Ã¦Å Å¾Ã¦â€“â€¡Ã¥Â­â€”Ã¥Ë†â€”Ã£Â�Â®Ã¥Â¾Å’Ã£Â�Â«Ã¦Å’Â¿Ã¥â€¦Â¥Ã£Â�â€”Ã£Â�Â¾Ã£Â�â„¢
         *
         * @param   {Element}   element         Ã¥Â¯Â¾Ã¨Â±Â¡Ã¨Â¦Â�Ã§Â´ 
         * @param   {String}    text            Ã¦Å’Â¿Ã¥â€¦Â¥Ã¦â€“â€¡Ã¥Â­â€”Ã¥Ë†â€”
         * @param   {String}    caret           Ã£â€šÂ­Ã£Æ’Â£Ã£Æ’Â¬Ã£Æ’Æ’Ã£Æ’Ë†Ã£Æ’Â¢Ã£Æ’Â¼Ã£Æ’â€° "keep" | "start" | "end" Ã£Â�Â®Ã£Â�â€žÃ£Â�Å¡Ã£â€šÅ’Ã£Â�â€¹
         */
        insertAfter: function(element, text, caret) {
            var tmp = _getCaretInfo(element),
                orig = element.value,
                pos = $(element).scrollTop(),
                range = {start: tmp.start, end: tmp.end};

            element.value = orig.substr(0, tmp.end) + text + orig.substr(tmp.end);

            $(element).scrollTop(pos);
            this.setPos(element, range, caret);
        }
    };

    /* jQuery.selection Ã£â€šâ€™Ã¨Â¿Â½Ã¥Å   */
    $.extend({
        /**
         * Ã£â€šÂ¦Ã£â€šÂ£Ã£Æ’Â³Ã£Æ’â€°Ã£â€šÂ¦Ã£Â�Â®Ã©Â�Â¸Ã¦Å Å¾Ã£Â�â€¢Ã£â€šÅ’Ã£Â�Â¦Ã£Â�â€žÃ£â€šâ€¹Ã¦â€“â€¡Ã¥Â­â€”Ã¥Ë†â€”Ã£â€šâ€™Ã¥Â�â€“Ã¥Â¾â€”
         *
         * @param   {String}    mode            Ã©Â�Â¸Ã¦Å Å¾Ã£Æ’Â¢Ã£Æ’Â¼Ã£Æ’â€° "text" | "html" Ã£Â�Â®Ã£Â�â€žÃ£Â�Å¡Ã£â€šÅ’Ã£Â�â€¹
         * @return  {String}    return
         */
        selectionCustom: function(mode) {
            var getText = ((mode || 'text').toLowerCase() == 'text');

            try {
                if (win.getSelection) {
                    if (getText) {
                        // get text
                        return win.getSelection().toString();
                    } else {
                        // get html
                        var sel = win.getSelection(), range;

                        if (sel.getRangeAt) {
                            range = sel.getRangeAt(0);
                        } else {
                            range = doc.createRange();
                            range.setStart(sel.anchorNode, sel.anchorOffset);
                            range.setEnd(sel.focusNode, sel.focusOffset);
                        }

                        return $('<div></div>').append(range.cloneContents()).html();
                    }
                } else if (doc.selection) {
                    if (getText) {
                        // get text
                        return doc.selection.createRange().text;
                    } else {
                        // get html
                        return doc.selection.createRange().htmlText;
                    }
                }
            } catch (e) {
                /* Ã£Â�â€šÃ£Â�Â�Ã£â€šâ€°Ã£â€šÂ�Ã£â€šâ€¹ */
            }

            return '';
        }
    });

    /* selection Ã£â€šâ€™Ã¨Â¿Â½Ã¥Å   */
    $.fn.extend({
    	selectionCustom: function(mode, opts) {
            opts = opts || {};

            switch (mode) {
                /**
                 * selection('getPos')
                 * Ã£â€šÂ­Ã£Æ’Â£Ã£Æ’Â¬Ã£Æ’Æ’Ã£Æ’Ë†Ã¤Â½Â�Ã§Â½Â®Ã£â€šâ€™Ã¥Â�â€“Ã¥Â¾â€”Ã£Â�â€”Ã£Â�Â¾Ã£Â�â„¢
                 *
                 * @return  {Object}    return
                 * @return  {Integer}   return.start    Ã©Â�Â¸Ã¦Å Å¾Ã©â€“â€¹Ã¥Â§â€¹Ã¤Â½Â�Ã§Â½Â®
                 * @return  {Integer}   return.end      Ã©Â�Â¸Ã¦Å Å¾Ã§Âµâ€šÃ¤Âºâ€ Ã¤Â½Â�Ã§Â½Â®
                 */
                case 'getPos':
                    return _CaretOperation.getPos(this[0]);
                    break;

                /**
                 * selection('setPos', opts)
                 * Ã£â€šÂ­Ã£Æ’Â£Ã£Æ’Â¬Ã£Æ’Æ’Ã£Æ’Ë†Ã¤Â½Â�Ã§Â½Â®Ã£â€šâ€™Ã¨Â¨Â­Ã¥Â®Å¡Ã£Â�â€”Ã£Â�Â¾Ã£Â�â„¢
                 *
                 * @param   {Integer}   opts.start      Ã©Â�Â¸Ã¦Å Å¾Ã©â€“â€¹Ã¥Â§â€¹Ã¤Â½Â�Ã§Â½Â®
                 * @param   {Integer}   opts.end        Ã©Â�Â¸Ã¦Å Å¾Ã§Âµâ€šÃ¤Âºâ€ Ã¤Â½Â�Ã§Â½Â®
                 */
                case 'setPos':
                    return this.each(function() {
                        _CaretOperation.setPos(this, opts);
                    });
                    break;

                /**
                 * selection('replace', opts)
                 * Ã©Â�Â¸Ã¦Å Å¾Ã¦â€“â€¡Ã¥Â­â€”Ã¥Ë†â€”Ã£â€šâ€™Ã§Â½Â®Ã£Â�Â�Ã¦Â�â€ºÃ£Â�Ë†Ã£Â�Â¾Ã£Â�â„¢
                 *
                 * @param   {String}    opts.text            Ã§Â½Â®Ã£Â�Â�Ã¦Â�â€ºÃ£Â�Ë†Ã£â€šâ€¹Ã¦â€“â€¡Ã¥Â­â€”Ã¥Ë†â€”
                 * @param   {String}    opts.caret           Ã£â€šÂ­Ã£Æ’Â£Ã£Æ’Â¬Ã£Æ’Æ’Ã£Æ’Ë†Ã£Æ’Â¢Ã£Æ’Â¼Ã£Æ’â€° "keep" | "start" | "end" Ã£Â�Â®Ã£Â�â€žÃ£Â�Å¡Ã£â€šÅ’Ã£Â�â€¹
                 */
                case 'replace':
                    return this.each(function() {
                        _CaretOperation.replace(this, opts.text, opts.caret);
                    });
                    break;

                /**
                 * selection('insert', opts)
                 * Ã©Â�Â¸Ã¦Å Å¾Ã¦â€“â€¡Ã¥Â­â€”Ã¥Ë†â€”Ã£Â�Â®Ã¥â€°Â�Ã£â‚¬Â�Ã£â€šâ€šÃ£Â�â€”Ã£Â�Â�Ã£Â�Â¯Ã¥Â¾Å’Ã£Â�Â«Ã¦â€“â€¡Ã¥Â­â€”Ã¥Ë†â€”Ã£â€šâ€™Ã¦Å’Â¿Ã¥â€¦Â¥Ã£Â�Ë†Ã£Â�Â¾Ã£Â�â„¢
                 *
                 * @param   {String}    opts.text            Ã¦Å’Â¿Ã¥â€¦Â¥Ã¦â€“â€¡Ã¥Â­â€”Ã¥Ë†â€”
                 * @param   {String}    opts.caret           Ã£â€šÂ­Ã£Æ’Â£Ã£Æ’Â¬Ã£Æ’Æ’Ã£Æ’Ë†Ã£Æ’Â¢Ã£Æ’Â¼Ã£Æ’â€° "keep" | "start" | "end" Ã£Â�Â®Ã£Â�â€žÃ£Â�Å¡Ã£â€šÅ’Ã£Â�â€¹
                 * @param   {String}    opts.mode            Ã¦Å’Â¿Ã¥â€¦Â¥Ã£Æ’Â¢Ã£Æ’Â¼Ã£Æ’â€° "before" | "after" Ã£Â�Â®Ã£Â�â€žÃ£Â�Å¡Ã£â€šÅ’Ã£Â�â€¹
                 */
                case 'insert':
                    return this.each(function() {
                        if (opts.mode == 'before') {
                            _CaretOperation.insertBefore(this, opts.text, opts.caret);
                        } else {
                            _CaretOperation.insertAfter(this, opts.text, opts.caret);
                        }
                    });

                    break;

                /**
                 * selection('get')
                 * Ã©Â�Â¸Ã¦Å Å¾Ã£Â�â€¢Ã£â€šÅ’Ã£Â�Â¦Ã£Â�â€žÃ£â€šâ€¹Ã¦â€“â€¡Ã¥Â­â€”Ã¥Ë†â€”Ã£â€šâ€™Ã¥Â�â€“Ã¥Â¾â€”
                 *
                 * @return  {String}    return
                 */
                case 'get':
                default:
                    return _CaretOperation.getText(this[0]);
                    break;
            }

            return this;
        }
    });
})(jQuery, window, window.document);