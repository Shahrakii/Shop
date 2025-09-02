/*!
 * AdminLTE v4.0.0-beta3 (https://adminlte.io)
 * Copyright 2014-2024 Colorlib <https://colorlib.com>
 * Licensed under MIT (https://github.com/ColorlibHQ/AdminLTE/blob/master/LICENSE)
 */

// Simple Jalali datepicker - basic version

// For Jalali to Gregorian conversion, use a helper function below.

(function() {
  // Jalali date conversion adapted from https://github.com/jalaali/jalaali-js (simplified)

  function div(a, b) {
    return ~~(a / b);
  }

  function jalaliToGregorian(jy, jm, jd) {
    var gy;
    if (jy > 979) {
      gy = 1600;
      jy -= 979;
    } else {
      gy = 621;
    }
    var days = 365 * jy + div(jy, 33) * 8 + div((jy % 33 + 3), 4) + 78 + jd + (jm < 7 ? (jm - 1) * 31 : (jm - 7) * 30 + 186);
    gy += 400 * div(days, 146097);
    days %= 146097;
    if (days > 36524) {
      gy += 100 * div(--days, 36524);
      days %= 36524;
      if (days >= 365) days++;
    }
    gy += 4 * div(days, 1461);
    days %= 1461;
    if (days > 365) {
      gy += div(days - 1, 365);
      days = (days - 1) % 365;
    }
    var gd = days + 1;
    var sal_a = [0, 31, (gy % 4 === 0 && gy % 100 !== 0) || gy % 400 === 0 ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
    var gm;
    for (gm = 0; gm < 13 && gd > sal_a[gm]; gm++) {
      gd -= sal_a[gm];
    }
    return {gy: gy, gm: gm, gd: gd};
  }

  // Format number with leading zero
  function pad(n) {
    return n < 10 ? '0' + n : n;
  }

  // Build a simple calendar UI inside a container div
  function buildCalendar(container, year, month, onSelect) {
    container.innerHTML = '';

    // Header with Month and Year (in Jalali)
    const months = ['فروردین','اردیبهشت','خرداد','تیر','مرداد','شهریور','مهر','آبان','آذر','دی','بهمن','اسفند'];
    const header = document.createElement('div');
    header.style.textAlign = 'center';
    header.style.marginBottom = '5px';

    const prevBtn = document.createElement('button');
    prevBtn.textContent = '<';
    prevBtn.style.marginRight = '10px';
    prevBtn.type = 'button';

    const nextBtn = document.createElement('button');
    nextBtn.textContent = '>';
    nextBtn.style.marginLeft = '10px';
    nextBtn.type = 'button';

    const title = document.createElement('span');
    title.textContent = `${months[month]} ${year}`;
    title.style.fontWeight = 'bold';

    header.appendChild(prevBtn);
    header.appendChild(title);
    header.appendChild(nextBtn);
    container.appendChild(header);

    // Days of the week (starting from Saturday)
    const daysRow = document.createElement('div');
    daysRow.style.display = 'flex';
    daysRow.style.justifyContent = 'space-between';
    daysRow.style.fontWeight = 'bold';
    daysRow.style.marginBottom = '5px';
    const daysOfWeek = ['ش','ی','د','س','چ','پ','ج']; // shorthand for Sat to Fri in Persian
    daysOfWeek.forEach(day => {
      const dayDiv = document.createElement('div');
      dayDiv.style.width = '30px';
      dayDiv.style.textAlign = 'center';
      dayDiv.textContent = day;
      daysRow.appendChild(dayDiv);
    });
    container.appendChild(daysRow);

    // Calculate the first day of month (Jalali)
    // Jalali to Gregorian for 1st day:
    const gDate = jalaliToGregorian(year, month + 1, 1);
    const firstDay = new Date(gDate.gy, gDate.gm -1, gDate.gd).getDay(); // Sun=0 ... Sat=6
    // We want Sat=0 to Fri=6, JS Sun=0 to Sat=6 => so convert
    // We'll map JS days so Sat=0..Fri=6:
    const dayMap = [6,0,1,2,3,4,5]; // JS Sun=0 mapped to 6 (Fri), Sat=6 mapped to 0
    const startDay = dayMap[firstDay];

    // Number of days in each Jalali month
    const daysInMonth = month < 6 ? 31 : (month < 11 ? 30 : (isLeapJalali(year) ? 30 : 29));

    // Fill blank slots before first day
    const datesRow = document.createElement('div');
    datesRow.style.display = 'flex';
    datesRow.style.flexWrap = 'wrap';
    datesRow.style.gap = '3px';

    // Total cells = 42 (6 weeks x 7 days)
    for(let i=0; i<42; i++) {
      const cell = document.createElement('div');
      cell.style.width = '30px';
      cell.style.height = '30px';
      cell.style.lineHeight = '30px';
      cell.style.textAlign = 'center';
      cell.style.cursor = 'pointer';
      cell.style.borderRadius = '4px';

      if(i < startDay || i >= daysInMonth + startDay) {
        cell.textContent = '';
      } else {
        const day = i - startDay + 1;
        cell.textContent = day;

        cell.addEventListener('click', () => {
          onSelect(year, month, day);
        });

        cell.addEventListener('mouseenter', () => {
          cell.style.backgroundColor = '#007bff';
          cell.style.color = 'white';
        });
        cell.addEventListener('mouseleave', () => {
          cell.style.backgroundColor = '';
          cell.style.color = '';
        });
      }
      datesRow.appendChild(cell);
    }

    container.appendChild(datesRow);

    // Prev/Next handlers
    prevBtn.addEventListener('click', () => {
      if (month === 0) {
        year--;
        month = 11;
      } else {
        month--;
      }
      buildCalendar(container, year, month, onSelect);
    });

    nextBtn.addEventListener('click', () => {
      if (month === 11) {
        year++;
        month = 0;
      } else {
        month++;
      }
      buildCalendar(container, year, month, onSelect);
    });
  }

  function isLeapJalali(jy) {
    var breaks = [ -61, 9, 38, 199, 426, 686, 756, 818, 1111,
      1181, 1210, 1635, 2060, 2097, 2192, 2262, 2324,
      2394, 2456, 3178 ];

    var bl = breaks.length,
        gy = jy + 621,
        leapJ = -14,
        jp = breaks[0],
        jm, jump, leap, n, i;

    if (jy < jp || jy >= breaks[bl - 1])
      throw new Error('Invalid Jalali year ' + jy);

    for (i = 1; i < bl; i += 1) {
      jm = breaks[i];
      jump = jm - jp;
      if (jy < jm)
        break;
      leapJ = leapJ + div(jump, 33) * 8 + div((jump % 33), 4);
      jp = jm;
    }
    n = jy - jp;

    leapJ = leapJ + div(n, 33) * 8 + div(((n % 33) + 3), 4);
    if ((jump % 33) === 4 && jump - n === 4)
      leapJ += 1;

    leap = (((leapJ + 1) % 33) - 1) % 4;
    return leap === -1 || leap === 0;
  }

  // Format jalali date YYYY/MM/DD with padded values
  function formatJalali(year, month, day) {
    return year + '/' + pad(month + 1) + '/' + pad(day);
  }

  // Format ISO date YYYY-MM-DD
  function formatISO(year, month, day) {
    return year + '-' + pad(month + 1) + '-' + pad(day);
  }

  // Initialize datepickers for inputs
  function initDatePicker(displayId, hiddenId) {
    const displayInput = document.getElementById(displayId);
    const hiddenInput = document.getElementById(hiddenId);

    // Create calendar container
    const calContainer = document.createElement('div');
    calContainer.style.position = 'absolute';
    calContainer.style.background = 'white';
    calContainer.style.border = '1px solid #ccc';
    calContainer.style.padding = '10px';
    calContainer.style.borderRadius = '4px';
    calContainer.style.zIndex = 10000;
    calContainer.style.display = 'none';
    calContainer.style.width = '260px';
    calContainer.style.userSelect = 'none';
    calContainer.style.boxShadow = '0 2px 8px rgba(0,0,0,0.15)';

    // Append to body
    document.body.appendChild(calContainer);

    // Position calendar below input
    function positionCalendar() {
      const rect = displayInput.getBoundingClientRect();
      calContainer.style.top = window.scrollY + rect.bottom + 'px';
      calContainer.style.left = window.scrollX + rect.left + 'px';
    }

    // Parse current date from hidden input (ISO format)
    function parseHiddenDate() {
      if (!hiddenInput.value) return null;
      const parts = hiddenInput.value.split('-');
      if (parts.length !== 3) return null;
      return { year: parseInt(parts[0]), month: parseInt(parts[1]) - 1, day: parseInt(parts[2]) };
    }

    // Convert Gregorian to Jalali for initial calendar state
    function gregorianToJalali(gy, gm, gd) {
      // Algorithm from jalaali-js (simplified)
      var g_d_m = [0,31,59,90,120,151,181,212,243,273,304,334];
      var jy;
      var gy2 = (gm > 1) ? (gy + 1) : gy;
      var days = 355666 + (365 * gy) + div((gy2 + 3), 4) - div((gy2 + 99), 100) + div((gy2 + 399), 400) + gd + g_d_m[gm-1];

      jy = -1595 + (33 * div(days, 12053));
      days %= 12053;
      jy += 4 * div(days, 1461);
      days %= 1461;
      if (days > 365) {
        jy += div((days - 1), 365);
        days = (days - 1) % 365;
      }
      var jm = (days < 186) ? 1 + div(days, 31) : 7 + div((days - 186), 30);
      var jd = 1 + ((days < 186) ? (days % 31) : ((days - 186) % 30));

      return { jy: jy, jm: jm - 1, jd: jd };
    }

    let currentDate = parseHiddenDate();

    if (!currentDate) {
      const now = new Date();
      const jDate = gregorianToJalali(now.getFullYear(), now.getMonth() + 1, now.getDate());
      currentDate = { year: jDate.jy, month: jDate.jm, day: jDate.jd };
    }

    function onSelect(year, month, day) {
      displayInput.value = formatJalali(year, month, day);
      hiddenInput.value = formatISO(...Object.values(jalaliToGregorian(year, month + 1, day)));
      calContainer.style.display = 'none';
    }

    displayInput.addEventListener('click', () => {
      positionCalendar();
      calContainer.style.display = calContainer.style.display === 'none' ? 'block' : 'none';
      buildCalendar(calContainer, currentDate.year, currentDate.month, (y,m,d) => {
        onSelect(y,m,d);
        currentDate = { year: y, month: m, day: d };
      });
    });

    // Close calendar when clicking outside
    document.addEventListener('click', (e) => {
      if (!calContainer.contains(e.target) && e.target !== displayInput) {
        calContainer.style.display = 'none';
      }
    });

    // Close on ESC
    document.addEventListener('keydown', e => {
      if (e.key === 'Escape') calContainer.style.display = 'none';
    });
  }

  // Initialize both pickers
  document.addEventListener('DOMContentLoaded', function() {
    initDatePicker('surgeried_at_display', 'surgeried_at');
    initDatePicker('released_at_display', 'released_at');
  });

})();


// Usage:
// Call this function for each input you want a Persian datepicker on:
function initPersianDatePicker(selector) {
  const inputs = document.querySelectorAll(selector);
  inputs.forEach(input => new PersianDatePicker(input));
}


(function (global, factory) {
    typeof exports === 'object' && typeof module !== 'undefined' ? factory(exports) :
    typeof define === 'function' && define.amd ? define(['exports'], factory) :
    (global = typeof globalThis !== 'undefined' ? globalThis : global || self, factory(global.adminlte = {}));
})(this, (function (exports) { 'use strict';

    const domContentLoadedCallbacks = [];
    const onDOMContentLoaded = (callback) => {
        if (document.readyState === 'loading') {
            // add listener on the first call when the document is in loading state
            if (!domContentLoadedCallbacks.length) {
                document.addEventListener('DOMContentLoaded', () => {
                    for (const callback of domContentLoadedCallbacks) {
                        callback();
                    }
                });
            }
            domContentLoadedCallbacks.push(callback);
        }
        else {
            callback();
        }
    };
    /* SLIDE UP */
    const slideUp = (target, duration = 500) => {
        target.style.transitionProperty = 'height, margin, padding';
        target.style.transitionDuration = `${duration}ms`;
        target.style.boxSizing = 'border-box';
        target.style.height = `${target.offsetHeight}px`;
        target.style.overflow = 'hidden';
        window.setTimeout(() => {
            target.style.height = '0';
            target.style.paddingTop = '0';
            target.style.paddingBottom = '0';
            target.style.marginTop = '0';
            target.style.marginBottom = '0';
        }, 1);
        window.setTimeout(() => {
            target.style.display = 'none';
            target.style.removeProperty('height');
            target.style.removeProperty('padding-top');
            target.style.removeProperty('padding-bottom');
            target.style.removeProperty('margin-top');
            target.style.removeProperty('margin-bottom');
            target.style.removeProperty('overflow');
            target.style.removeProperty('transition-duration');
            target.style.removeProperty('transition-property');
        }, duration);
    };
    /* SLIDE DOWN */
    const slideDown = (target, duration = 500) => {
        target.style.removeProperty('display');
        let { display } = window.getComputedStyle(target);
        if (display === 'none') {
            display = 'block';
        }
        target.style.display = display;
        const height = target.offsetHeight;
        target.style.overflow = 'hidden';
        target.style.height = '0';
        target.style.paddingTop = '0';
        target.style.paddingBottom = '0';
        target.style.marginTop = '0';
        target.style.marginBottom = '0';
        window.setTimeout(() => {
            target.style.boxSizing = 'border-box';
            target.style.transitionProperty = 'height, margin, padding';
            target.style.transitionDuration = `${duration}ms`;
            target.style.height = `${height}px`;
            target.style.removeProperty('padding-top');
            target.style.removeProperty('padding-bottom');
            target.style.removeProperty('margin-top');
            target.style.removeProperty('margin-bottom');
        }, 1);
        window.setTimeout(() => {
            target.style.removeProperty('height');
            target.style.removeProperty('overflow');
            target.style.removeProperty('transition-duration');
            target.style.removeProperty('transition-property');
        }, duration);
    };

    /**
     * --------------------------------------------
     * @file AdminLTE layout.ts
     * @description Layout for AdminLTE.
     * @license MIT
     * --------------------------------------------
     */
    /**
     * ------------------------------------------------------------------------
     * Constants
     * ------------------------------------------------------------------------
     */
    const CLASS_NAME_HOLD_TRANSITIONS = 'hold-transition';
    const CLASS_NAME_APP_LOADED = 'app-loaded';
    /**
     * Class Definition
     * ====================================================
     */
    class Layout {
        constructor(element) {
            this._element = element;
        }
        holdTransition() {
            let resizeTimer;
            window.addEventListener('resize', () => {
                document.body.classList.add(CLASS_NAME_HOLD_TRANSITIONS);
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(() => {
                    document.body.classList.remove(CLASS_NAME_HOLD_TRANSITIONS);
                }, 400);
            });
        }
    }
    onDOMContentLoaded(() => {
        const data = new Layout(document.body);
        data.holdTransition();
        setTimeout(() => {
            document.body.classList.add(CLASS_NAME_APP_LOADED);
        }, 400);
    });

    /**
     * --------------------------------------------
     * @file AdminLTE push-menu.ts
     * @description Push menu for AdminLTE.
     * @license MIT
     * --------------------------------------------
     */
    /**
     * ------------------------------------------------------------------------
     * Constants
     * ------------------------------------------------------------------------
     */
    const DATA_KEY$4 = 'lte.push-menu';
    const EVENT_KEY$4 = `.${DATA_KEY$4}`;
    const EVENT_OPEN = `open${EVENT_KEY$4}`;
    const EVENT_COLLAPSE = `collapse${EVENT_KEY$4}`;
    const CLASS_NAME_SIDEBAR_MINI = 'sidebar-mini';
    const CLASS_NAME_SIDEBAR_COLLAPSE = 'sidebar-collapse';
    const CLASS_NAME_SIDEBAR_OPEN = 'sidebar-open';
    const CLASS_NAME_SIDEBAR_EXPAND = 'sidebar-expand';
    const CLASS_NAME_SIDEBAR_OVERLAY = 'sidebar-overlay';
    const CLASS_NAME_MENU_OPEN$1 = 'menu-open';
    const SELECTOR_APP_SIDEBAR = '.app-sidebar';
    const SELECTOR_SIDEBAR_MENU = '.sidebar-menu';
    const SELECTOR_NAV_ITEM$1 = '.nav-item';
    const SELECTOR_NAV_TREEVIEW = '.nav-treeview';
    const SELECTOR_APP_WRAPPER = '.app-wrapper';
    const SELECTOR_SIDEBAR_EXPAND = `[class*="${CLASS_NAME_SIDEBAR_EXPAND}"]`;
    const SELECTOR_SIDEBAR_TOGGLE = '[data-lte-toggle="sidebar"]';
    const Defaults = {
        sidebarBreakpoint: 992
    };
    /**
     * Class Definition
     * ====================================================
     */
    class PushMenu {
        constructor(element, config) {
            this._element = element;
            this._config = Object.assign(Object.assign({}, Defaults), config);
        }
        // TODO
        menusClose() {
            const navTreeview = document.querySelectorAll(SELECTOR_NAV_TREEVIEW);
            navTreeview.forEach(navTree => {
                navTree.style.removeProperty('display');
                navTree.style.removeProperty('height');
            });
            const navSidebar = document.querySelector(SELECTOR_SIDEBAR_MENU);
            const navItem = navSidebar === null || navSidebar === void 0 ? void 0 : navSidebar.querySelectorAll(SELECTOR_NAV_ITEM$1);
            if (navItem) {
                navItem.forEach(navI => {
                    navI.classList.remove(CLASS_NAME_MENU_OPEN$1);
                });
            }
        }
        expand() {
            const event = new Event(EVENT_OPEN);
            document.body.classList.remove(CLASS_NAME_SIDEBAR_COLLAPSE);
            document.body.classList.add(CLASS_NAME_SIDEBAR_OPEN);
            this._element.dispatchEvent(event);
        }
        collapse() {
            const event = new Event(EVENT_COLLAPSE);
            document.body.classList.remove(CLASS_NAME_SIDEBAR_OPEN);
            document.body.classList.add(CLASS_NAME_SIDEBAR_COLLAPSE);
            this._element.dispatchEvent(event);
        }
        addSidebarBreakPoint() {
            var _a, _b, _c;
            const sidebarExpandList = (_b = (_a = document.querySelector(SELECTOR_SIDEBAR_EXPAND)) === null || _a === void 0 ? void 0 : _a.classList) !== null && _b !== void 0 ? _b : [];
            const sidebarExpand = (_c = Array.from(sidebarExpandList).find(className => className.startsWith(CLASS_NAME_SIDEBAR_EXPAND))) !== null && _c !== void 0 ? _c : '';
            const sidebar = document.getElementsByClassName(sidebarExpand)[0];
            const sidebarContent = window.getComputedStyle(sidebar, '::before').getPropertyValue('content');
            this._config = Object.assign(Object.assign({}, this._config), { sidebarBreakpoint: Number(sidebarContent.replace(/[^\d.-]/g, '')) });
            if (window.innerWidth <= this._config.sidebarBreakpoint) {
                this.collapse();
            }
            else {
                if (!document.body.classList.contains(CLASS_NAME_SIDEBAR_MINI)) {
                    this.expand();
                }
                if (document.body.classList.contains(CLASS_NAME_SIDEBAR_MINI) && document.body.classList.contains(CLASS_NAME_SIDEBAR_COLLAPSE)) {
                    this.collapse();
                }
            }
        }
        toggle() {
            if (document.body.classList.contains(CLASS_NAME_SIDEBAR_COLLAPSE)) {
                this.expand();
            }
            else {
                this.collapse();
            }
        }
        init() {
            this.addSidebarBreakPoint();
        }
    }
    /**
     * ------------------------------------------------------------------------
     * Data Api implementation
     * ------------------------------------------------------------------------
     */
    onDOMContentLoaded(() => {
        var _a;
        const sidebar = document === null || document === void 0 ? void 0 : document.querySelector(SELECTOR_APP_SIDEBAR);
        if (sidebar) {
            const data = new PushMenu(sidebar, Defaults);
            data.init();
            window.addEventListener('resize', () => {
                data.init();
            });
        }
        const sidebarOverlay = document.createElement('div');
        sidebarOverlay.className = CLASS_NAME_SIDEBAR_OVERLAY;
        (_a = document.querySelector(SELECTOR_APP_WRAPPER)) === null || _a === void 0 ? void 0 : _a.append(sidebarOverlay);
        sidebarOverlay.addEventListener('touchstart', event => {
            event.preventDefault();
            const target = event.currentTarget;
            const data = new PushMenu(target, Defaults);
            data.collapse();
        }, { passive: true });
        sidebarOverlay.addEventListener('click', event => {
            event.preventDefault();
            const target = event.currentTarget;
            const data = new PushMenu(target, Defaults);
            data.collapse();
        });
        const fullBtn = document.querySelectorAll(SELECTOR_SIDEBAR_TOGGLE);
        fullBtn.forEach(btn => {
            btn.addEventListener('click', event => {
                event.preventDefault();
                let button = event.currentTarget;
                if ((button === null || button === void 0 ? void 0 : button.dataset.lteToggle) !== 'sidebar') {
                    button = button === null || button === void 0 ? void 0 : button.closest(SELECTOR_SIDEBAR_TOGGLE);
                }
                if (button) {
                    event === null || event === void 0 ? void 0 : event.preventDefault();
                    const data = new PushMenu(button, Defaults);
                    data.toggle();
                }
            });
        });
    });

    /**
     * --------------------------------------------
     * @file AdminLTE treeview.ts
     * @description Treeview plugin for AdminLTE.
     * @license MIT
     * --------------------------------------------
     */
    /**
     * ------------------------------------------------------------------------
     * Constants
     * ------------------------------------------------------------------------
     */
    // const NAME = 'Treeview'
    const DATA_KEY$3 = 'lte.treeview';
    const EVENT_KEY$3 = `.${DATA_KEY$3}`;
    const EVENT_EXPANDED$2 = `expanded${EVENT_KEY$3}`;
    const EVENT_COLLAPSED$2 = `collapsed${EVENT_KEY$3}`;
    // const EVENT_LOAD_DATA_API = `load${EVENT_KEY}`
    const CLASS_NAME_MENU_OPEN = 'menu-open';
    const SELECTOR_NAV_ITEM = '.nav-item';
    const SELECTOR_NAV_LINK = '.nav-link';
    const SELECTOR_TREEVIEW_MENU = '.nav-treeview';
    const SELECTOR_DATA_TOGGLE$1 = '[data-lte-toggle="treeview"]';
    const Default$1 = {
        animationSpeed: 300,
        accordion: true
    };
    /**
     * Class Definition
     * ====================================================
     */
    class Treeview {
        constructor(element, config) {
            this._element = element;
            this._config = Object.assign(Object.assign({}, Default$1), config);
        }
        open() {
            var _a, _b;
            const event = new Event(EVENT_EXPANDED$2);
            if (this._config.accordion) {
                const openMenuList = (_a = this._element.parentElement) === null || _a === void 0 ? void 0 : _a.querySelectorAll(`${SELECTOR_NAV_ITEM}.${CLASS_NAME_MENU_OPEN}`);
                openMenuList === null || openMenuList === void 0 ? void 0 : openMenuList.forEach(openMenu => {
                    if (openMenu !== this._element.parentElement) {
                        openMenu.classList.remove(CLASS_NAME_MENU_OPEN);
                        const childElement = openMenu === null || openMenu === void 0 ? void 0 : openMenu.querySelector(SELECTOR_TREEVIEW_MENU);
                        if (childElement) {
                            slideUp(childElement, this._config.animationSpeed);
                        }
                    }
                });
            }
            this._element.classList.add(CLASS_NAME_MENU_OPEN);
            const childElement = (_b = this._element) === null || _b === void 0 ? void 0 : _b.querySelector(SELECTOR_TREEVIEW_MENU);
            if (childElement) {
                slideDown(childElement, this._config.animationSpeed);
            }
            this._element.dispatchEvent(event);
        }
        close() {
            var _a;
            const event = new Event(EVENT_COLLAPSED$2);
            this._element.classList.remove(CLASS_NAME_MENU_OPEN);
            const childElement = (_a = this._element) === null || _a === void 0 ? void 0 : _a.querySelector(SELECTOR_TREEVIEW_MENU);
            if (childElement) {
                slideUp(childElement, this._config.animationSpeed);
            }
            this._element.dispatchEvent(event);
        }
        toggle() {
            if (this._element.classList.contains(CLASS_NAME_MENU_OPEN)) {
                this.close();
            }
            else {
                this.open();
            }
        }
    }
    /**
     * ------------------------------------------------------------------------
     * Data Api implementation
     * ------------------------------------------------------------------------
     */
    onDOMContentLoaded(() => {
        const button = document.querySelectorAll(SELECTOR_DATA_TOGGLE$1);
        button.forEach(btn => {
            btn.addEventListener('click', event => {
                const target = event.target;
                const targetItem = target.closest(SELECTOR_NAV_ITEM);
                const targetLink = target.closest(SELECTOR_NAV_LINK);
                if ((target === null || target === void 0 ? void 0 : target.getAttribute('href')) === '#' || (targetLink === null || targetLink === void 0 ? void 0 : targetLink.getAttribute('href')) === '#') {
                    event.preventDefault();
                }
                if (targetItem) {
                    const data = new Treeview(targetItem, Default$1);
                    data.toggle();
                }
            });
        });
    });

    /**
     * --------------------------------------------
     * @file AdminLTE direct-chat.ts
     * @description Direct chat for AdminLTE.
     * @license MIT
     * --------------------------------------------
     */
    /**
     * Constants
     * ====================================================
     */
    const DATA_KEY$2 = 'lte.direct-chat';
    const EVENT_KEY$2 = `.${DATA_KEY$2}`;
    const EVENT_EXPANDED$1 = `expanded${EVENT_KEY$2}`;
    const EVENT_COLLAPSED$1 = `collapsed${EVENT_KEY$2}`;
    const SELECTOR_DATA_TOGGLE = '[data-lte-toggle="chat-pane"]';
    const SELECTOR_DIRECT_CHAT = '.direct-chat';
    const CLASS_NAME_DIRECT_CHAT_OPEN = 'direct-chat-contacts-open';
    /**
     * Class Definition
     * ====================================================
     */
    class DirectChat {
        constructor(element) {
            this._element = element;
        }
        toggle() {
            if (this._element.classList.contains(CLASS_NAME_DIRECT_CHAT_OPEN)) {
                const event = new Event(EVENT_COLLAPSED$1);
                this._element.classList.remove(CLASS_NAME_DIRECT_CHAT_OPEN);
                this._element.dispatchEvent(event);
            }
            else {
                const event = new Event(EVENT_EXPANDED$1);
                this._element.classList.add(CLASS_NAME_DIRECT_CHAT_OPEN);
                this._element.dispatchEvent(event);
            }
        }
    }
    /**
     *
     * Data Api implementation
     * ====================================================
     */
    onDOMContentLoaded(() => {
        const button = document.querySelectorAll(SELECTOR_DATA_TOGGLE);
        button.forEach(btn => {
            btn.addEventListener('click', event => {
                event.preventDefault();
                const target = event.target;
                const chatPane = target.closest(SELECTOR_DIRECT_CHAT);
                if (chatPane) {
                    const data = new DirectChat(chatPane);
                    data.toggle();
                }
            });
        });
    });

    /**
     * --------------------------------------------
     * @file AdminLTE card-widget.ts
     * @description Card widget for AdminLTE.
     * @license MIT
     * --------------------------------------------
     */
    /**
     * Constants
     * ====================================================
     */
    const DATA_KEY$1 = 'lte.card-widget';
    const EVENT_KEY$1 = `.${DATA_KEY$1}`;
    const EVENT_COLLAPSED = `collapsed${EVENT_KEY$1}`;
    const EVENT_EXPANDED = `expanded${EVENT_KEY$1}`;
    const EVENT_REMOVE = `remove${EVENT_KEY$1}`;
    const EVENT_MAXIMIZED$1 = `maximized${EVENT_KEY$1}`;
    const EVENT_MINIMIZED$1 = `minimized${EVENT_KEY$1}`;
    const CLASS_NAME_CARD = 'card';
    const CLASS_NAME_COLLAPSED = 'collapsed-card';
    const CLASS_NAME_COLLAPSING = 'collapsing-card';
    const CLASS_NAME_EXPANDING = 'expanding-card';
    const CLASS_NAME_WAS_COLLAPSED = 'was-collapsed';
    const CLASS_NAME_MAXIMIZED = 'maximized-card';
    const SELECTOR_DATA_REMOVE = '[data-lte-toggle="card-remove"]';
    const SELECTOR_DATA_COLLAPSE = '[data-lte-toggle="card-collapse"]';
    const SELECTOR_DATA_MAXIMIZE = '[data-lte-toggle="card-maximize"]';
    const SELECTOR_CARD = `.${CLASS_NAME_CARD}`;
    const SELECTOR_CARD_BODY = '.card-body';
    const SELECTOR_CARD_FOOTER = '.card-footer';
    const Default = {
        animationSpeed: 500,
        collapseTrigger: SELECTOR_DATA_COLLAPSE,
        removeTrigger: SELECTOR_DATA_REMOVE,
        maximizeTrigger: SELECTOR_DATA_MAXIMIZE
    };
    class CardWidget {
        constructor(element, config) {
            this._element = element;
            this._parent = element.closest(SELECTOR_CARD);
            if (element.classList.contains(CLASS_NAME_CARD)) {
                this._parent = element;
            }
            this._config = Object.assign(Object.assign({}, Default), config);
        }
        collapse() {
            var _a, _b;
            const event = new Event(EVENT_COLLAPSED);
            if (this._parent) {
                this._parent.classList.add(CLASS_NAME_COLLAPSING);
                const elm = (_a = this._parent) === null || _a === void 0 ? void 0 : _a.querySelectorAll(`${SELECTOR_CARD_BODY}, ${SELECTOR_CARD_FOOTER}`);
                elm.forEach(el => {
                    if (el instanceof HTMLElement) {
                        slideUp(el, this._config.animationSpeed);
                    }
                });
                setTimeout(() => {
                    if (this._parent) {
                        this._parent.classList.add(CLASS_NAME_COLLAPSED);
                        this._parent.classList.remove(CLASS_NAME_COLLAPSING);
                    }
                }, this._config.animationSpeed);
            }
            (_b = this._element) === null || _b === void 0 ? void 0 : _b.dispatchEvent(event);
        }
        expand() {
            var _a, _b;
            const event = new Event(EVENT_EXPANDED);
            if (this._parent) {
                this._parent.classList.add(CLASS_NAME_EXPANDING);
                const elm = (_a = this._parent) === null || _a === void 0 ? void 0 : _a.querySelectorAll(`${SELECTOR_CARD_BODY}, ${SELECTOR_CARD_FOOTER}`);
                elm.forEach(el => {
                    if (el instanceof HTMLElement) {
                        slideDown(el, this._config.animationSpeed);
                    }
                });
                setTimeout(() => {
                    if (this._parent) {
                        this._parent.classList.remove(CLASS_NAME_COLLAPSED);
                        this._parent.classList.remove(CLASS_NAME_EXPANDING);
                    }
                }, this._config.animationSpeed);
            }
            (_b = this._element) === null || _b === void 0 ? void 0 : _b.dispatchEvent(event);
        }
        remove() {
            var _a;
            const event = new Event(EVENT_REMOVE);
            if (this._parent) {
                slideUp(this._parent, this._config.animationSpeed);
            }
            (_a = this._element) === null || _a === void 0 ? void 0 : _a.dispatchEvent(event);
        }
        toggle() {
            var _a;
            if ((_a = this._parent) === null || _a === void 0 ? void 0 : _a.classList.contains(CLASS_NAME_COLLAPSED)) {
                this.expand();
                return;
            }
            this.collapse();
        }
        maximize() {
            var _a;
            const event = new Event(EVENT_MAXIMIZED$1);
            if (this._parent) {
                this._parent.style.height = `${this._parent.offsetHeight}px`;
                this._parent.style.width = `${this._parent.offsetWidth}px`;
                this._parent.style.transition = 'all .15s';
                setTimeout(() => {
                    const htmlTag = document.querySelector('html');
                    if (htmlTag) {
                        htmlTag.classList.add(CLASS_NAME_MAXIMIZED);
                    }
                    if (this._parent) {
                        this._parent.classList.add(CLASS_NAME_MAXIMIZED);
                        if (this._parent.classList.contains(CLASS_NAME_COLLAPSED)) {
                            this._parent.classList.add(CLASS_NAME_WAS_COLLAPSED);
                        }
                    }
                }, 150);
            }
            (_a = this._element) === null || _a === void 0 ? void 0 : _a.dispatchEvent(event);
        }
        minimize() {
            var _a;
            const event = new Event(EVENT_MINIMIZED$1);
            if (this._parent) {
                this._parent.style.height = 'auto';
                this._parent.style.width = 'auto';
                this._parent.style.transition = 'all .15s';
                setTimeout(() => {
                    var _a;
                    const htmlTag = document.querySelector('html');
                    if (htmlTag) {
                        htmlTag.classList.remove(CLASS_NAME_MAXIMIZED);
                    }
                    if (this._parent) {
                        this._parent.classList.remove(CLASS_NAME_MAXIMIZED);
                        if ((_a = this._parent) === null || _a === void 0 ? void 0 : _a.classList.contains(CLASS_NAME_WAS_COLLAPSED)) {
                            this._parent.classList.remove(CLASS_NAME_WAS_COLLAPSED);
                        }
                    }
                }, 10);
            }
            (_a = this._element) === null || _a === void 0 ? void 0 : _a.dispatchEvent(event);
        }
        toggleMaximize() {
            var _a;
            if ((_a = this._parent) === null || _a === void 0 ? void 0 : _a.classList.contains(CLASS_NAME_MAXIMIZED)) {
                this.minimize();
                return;
            }
            this.maximize();
        }
    }
    /**
     *
     * Data Api implementation
     * ====================================================
     */
    onDOMContentLoaded(() => {
        const collapseBtn = document.querySelectorAll(SELECTOR_DATA_COLLAPSE);
        collapseBtn.forEach(btn => {
            btn.addEventListener('click', event => {
                event.preventDefault();
                const target = event.target;
                const data = new CardWidget(target, Default);
                data.toggle();
            });
        });
        const removeBtn = document.querySelectorAll(SELECTOR_DATA_REMOVE);
        removeBtn.forEach(btn => {
            btn.addEventListener('click', event => {
                event.preventDefault();
                const target = event.target;
                const data = new CardWidget(target, Default);
                data.remove();
            });
        });
        const maxBtn = document.querySelectorAll(SELECTOR_DATA_MAXIMIZE);
        maxBtn.forEach(btn => {
            btn.addEventListener('click', event => {
                event.preventDefault();
                const target = event.target;
                const data = new CardWidget(target, Default);
                data.toggleMaximize();
            });
        });
    });

    /**
     * --------------------------------------------
     * @file AdminLTE fullscreen.ts
     * @description Fullscreen plugin for AdminLTE.
     * @license MIT
     * --------------------------------------------
     */
    /**
     * Constants
     * ============================================================================
     */
    const DATA_KEY = 'lte.fullscreen';
    const EVENT_KEY = `.${DATA_KEY}`;
    const EVENT_MAXIMIZED = `maximized${EVENT_KEY}`;
    const EVENT_MINIMIZED = `minimized${EVENT_KEY}`;
    const SELECTOR_FULLSCREEN_TOGGLE = '[data-lte-toggle="fullscreen"]';
    const SELECTOR_MAXIMIZE_ICON = '[data-lte-icon="maximize"]';
    const SELECTOR_MINIMIZE_ICON = '[data-lte-icon="minimize"]';
    /**
     * Class Definition.
     * ============================================================================
     */
    class FullScreen {
        constructor(element, config) {
            this._element = element;
            this._config = config;
        }
        inFullScreen() {
            const event = new Event(EVENT_MAXIMIZED);
            const iconMaximize = document.querySelector(SELECTOR_MAXIMIZE_ICON);
            const iconMinimize = document.querySelector(SELECTOR_MINIMIZE_ICON);
            void document.documentElement.requestFullscreen();
            if (iconMaximize) {
                iconMaximize.style.display = 'none';
            }
            if (iconMinimize) {
                iconMinimize.style.display = 'block';
            }
            this._element.dispatchEvent(event);
        }
        outFullscreen() {
            const event = new Event(EVENT_MINIMIZED);
            const iconMaximize = document.querySelector(SELECTOR_MAXIMIZE_ICON);
            const iconMinimize = document.querySelector(SELECTOR_MINIMIZE_ICON);
            void document.exitFullscreen();
            if (iconMaximize) {
                iconMaximize.style.display = 'block';
            }
            if (iconMinimize) {
                iconMinimize.style.display = 'none';
            }
            this._element.dispatchEvent(event);
        }
        toggleFullScreen() {
            if (document.fullscreenEnabled) {
                if (document.fullscreenElement) {
                    this.outFullscreen();
                }
                else {
                    this.inFullScreen();
                }
            }
        }
    }
    /**
     * Data Api implementation
     * ============================================================================
     */
    onDOMContentLoaded(() => {
        const buttons = document.querySelectorAll(SELECTOR_FULLSCREEN_TOGGLE);
        buttons.forEach(btn => {
            btn.addEventListener('click', event => {
                event.preventDefault();
                const target = event.target;
                const button = target.closest(SELECTOR_FULLSCREEN_TOGGLE);
                if (button) {
                    const data = new FullScreen(button, undefined);
                    data.toggleFullScreen();
                }
            });
        });
    });

    exports.CardWidget = CardWidget;
    exports.DirectChat = DirectChat;
    exports.FullScreen = FullScreen;
    exports.Layout = Layout;
    exports.PushMenu = PushMenu;
    exports.Treeview = Treeview;

}));
//# sourceMappingURL=adminlte.js.map

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>