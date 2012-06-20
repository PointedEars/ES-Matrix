"use strict";
/**
 * @fileOverview <title>ECMAScript Edition 5.1 Reference Implementation</title>
 * @file $Id$
 *
 * @author (C) 2012 <a href="mailto:js@PointedEars.de">Thomas Lahn</a>
 *
 * This program is (intended to be) a complete reference
 * implementation of the ECMAScript Language Specification,
 * 5.1 Edition, written in ECMAScript.  It should be used
 * to determine the degree of conformance of existing
 * ECMAScript implementations to the Edition they claim
 * to implement, respectively.
 *
 * These implementations of ECMAScript algorithms are intentionally
 * not optimized for speed and memory footprint, but towards
 * a maximum degree of standards compliance and clarity.  They are
 * therefore _not_ suited as-is for emulations of ECMAScript
 * features that are potentially missing in implementations or
 * implemented in a non-conforming way.  You have been warned.
 * However, optimized versions of this code may be used in feature
 * emulation, as they are used, for example, in JSX:object.js.
 *
 * @partof ECMAScript Support Matrix (ES Matrix)
 *
 * The ES Matrix is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation, either version 3 of
 * the License, or (at your option) any later version.
 *
 * The ES Matrix is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ES Matrix.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * @namespace
 */
var es = {
  /* Data types */
  T_OTHER: -2,
  T_UNDEFINED: -1,
  T_NULL: 0,
  T_BOOLEAN: 1,
  T_STRING: 2,
  T_NUMBER: 3,
  T_OBJECT: 4,

  /**
   * Implements the "Type(arg)" value in ECMAScript algorithms.
   *
   * @param arg
   */
  Type: function (arg) {
    var t = typeof arg;

    if (t == "undefined")
    {
      return es.T_UNDEFINED;
    }

    if (arg === null)
    {
      return es.T_NULL;
    }

    if (t == "boolean")
    {
      return es.T_BOOLEAN;
    }

    if (t == "string")
    {
      return es.T_STRING;
    }

    if (t == "number")
    {
      return es.T_NUMBER;
    }

    if (t == "object")
    {
      return es.T_OBJECT;
    }

    /* Specification Types not yet implemented */
    return es.T_OTHER;
  },

  isPrimitive: function (arg) {
    var t = typeof arg;
    return (t == "undefined" || t == "boolean" || t == "string" || t == "number");
  },

  /**
   * Implements the "is an object" clause in ECMAScript algorithms.
   *
   * An value "is an object" if it is a function or <code>typeof "object"</code>
   * but not <code>null</code>.
   *
   * @param arg
   */
  isObject: function (arg) {
    var t = typeof arg;
    return t == "function" || t == "object" && arg !== null;
  },

  /**
   * "The mathematical function abs(x) yields the absolute value of x,
   * which is x if x is negative (less than zero) and otherwise is x itself.
   *
   * @param x
   * @returns number
   */
  abs: function (x) {
    return (x < 0) ? -x : x;
  },

  /**
   * "The mathematical function floor(x) yields the largest integer
   * (closest to positive infinity) that is not larger than x."
   *
   * @param x
   */
  floor: function (x) {
    return x - ((x < 0) ? 1 - (x % 1) : x % 1);
  },

  min: function (a, b) {
    return (a < b) ? a : b;
  },

  max: function (a, b) {
    return (a > b) ? a : b;
  },

  /**
   * "The mathematical function sign(x) yields 1 if x is positive
   * and −1 if x is negative. The sign function is not used in this
   * standard for cases when x is zero."
   *
   * @param x
   * @returns number
   */
  sign: function (x) {
    return (x > 0) ? 1 : -1;
  },

  /**
   * Returns a repeated string
   *
   * @param str : String
   *   String to be repeated.
   * @param times : Number
   *   The number of times <var>str</var> should be repeated
   * @returns String
   */
  repeat: function (str, times) {
    var a = [];
    if (times < 2)
    {
      if (times < 1)
      {
        return "";
      }

      return str;
    }

    a.length = times + 1;
    return a.join(str);
  },

  shift: function (obj) {
    var first = obj[0];

    for (var i = 1, len = obj.length; i < len; ++i)
    {
      obj[i - 1] = obj[i];
    }

    delete obj[obj.length - 1];
    --obj.length;

    return first;
  },

  slice: function (obj, startIndex, endIndex) {
    var a = [];
    var count = 0;

    for (var i = startIndex; i < endIndex; ++i)
    {
      a[count++] = obj[i];
    }

    return a;
  },

  DefaultValue: function (o, hint) {
    /*
     * "When the [[DefaultValue]] internal method of O is called
     * with no hint, then it behaves as if the hint were Number,
     * unless O is a Date object (see 15.9.6), in which case
     * it behaves as if the hint were String."
     */
    if (typeof hint == "undefined")
    {
      hint = es.T_NUMBER;

      if (es.getClass(o) == "Date")
      {
        hint = es.T_STRING;
      }
    }

    if (hint == es.T_STRING)
    {
      /*
       * "1. Let toString be the result of calling the [[Get]]
       * internal method of object O with argument "toString".
       */
      var toString = o.toString;

      /* "2. If IsCallable(toString) is true then," */
      if (es.IsCallable(toString))
      {
        /*
         * "a. Let str be the result of calling the [[Call]]
         *     internal method of toString, with O as
         *     the this value and an empty argument list."
         */
        var str = toString.call(o);

        /* "b. If str is a primitive value, return str." */
        if (es.isPrimitive(str))
        {
          return str;
        }
      }

      /*
       * "3. Let valueOf be the result of calling the [[Get]]
       *     internal method of object O with argument "valueOf"."
       */
      var valueOf = o.valueOf;

      /* 4. If IsCallable(valueOf) is true then, */
      if (es.IsCallable(valueOf))
      {
        /*
         * "a. Let val be the result of calling the [[Call]]
         *     internal method of valueOf, with O as the
         *     this value and an empty argument list."
         */
        var val = valueOf.call(o);

        /* "b. If val is a primitive value, return val." */
        if (es.isPrimitive(val))
        {
          return val;
        }
      }

      /* "5. Throw a TypeError exception." */
      eval("throw new TypeError();");
    }
    else if (hint == es.T_NUMBER)
    {
      /*
       * "1. Let valueOf be the result of calling the [[Get]]
       *     internal method of object O with argument "valueOf"."
       */
      var valueOf = o.valueOf;

      /* "2. If IsCallable(valueOf) is true then," */
      if (es.IsCallable(valueOf))
      {
        /*
         * "a. Let val be the result of calling the [[Call]]
         *     internal method of valueOf, with O as the
         *     this value and an empty argument list."
         */
        var str = valueOf.call(o);

        /* b. If val is a primitive value, return val. */
        if (es.isPrimitive(val))
        {
          return val;
        }
      }

      /*
       * "3. Let toString be the result of calling the [[Get]]
       *     internal method of object O with argument "toString"."
       */
      var toString = o.toString;

      /* 4. If IsCallable(toString) is true then, */
      if (es.IsCallable(toString))
      {
        /*
         * "a. Let str be the result of calling the [[Call]]
         *     internal method of toString, with O as the
         *     this value and an empty argument list."
         */
        var str = toString.call(o);

        /* "b. If str is a primitive value, return str." */
        if (es.isPrimitive(str))
        {
          return str;
        }
      }

      /* "5. Throw a TypeError exception." */
      eval("throw new TypeError();");
    }
  },

  /**
   * "9.1 ToPrimitive
   *
   * The abstract operation ToPrimitive takes an input argument
   * and an optional argument PreferredType. The abstract operation
   * ToPrimitive converts its input argument to a non-Object type.
   * If an object is capable of converting to more than one
   * primitive type, it may use the optional hint PreferredType
   * to favour that type."
   *
   * @param input : mixed
   * @param preferredType : Number
   * @returns mixed
   */
  ToPrimitive: function (input, preferredType) {
    var t = es.Type(input);

    if (t == es.T_UNDEFINED || t == es.T_NULL || t == es.T_BOOLEAN
        || t == es.T_NUMBER || t == es.T_STRING)
    {
      return input;
    }

    if (t == es.T_OBJECT)
    {
      return es.DefaultValue(input, preferredType);
    }
  },

  /**
   * "9.3 ToNumber
   *
   * The abstract operation ToNumber converts its argument to
   * a value of type Number …"
   *
   * @param arg
   * @returns number
   */
  ToNumber: function (arg) {
    var t = es.Type(arg);

    if (t == es.T_UNDEFINED)
    {
      return NaN;
    }

    if (t == es.T_NULL)
    {
      return +0;
    }

    if (t == es.T_BOOLEAN)
    {
      return (arg === true) ? 1 : +0;
    }

    if (t == es.T_NUMBER)
    {
      return arg;
    }

    if (t == "String")
    {
      +arg;
    }

    if (t == es.T_OBJECT)
    {
      /*
       * "1. Let primValue be ToPrimitive(input argument, hint Number)."
       */
      var primValue = es.ToPrimitive(arg, es.T_NUMBER);
      return es.ToNumber(primValue);
    }
  },

  /**
   * "9.4 ToInteger
   *
   * The abstract operation ToInteger converts its argument to
   * an integral numeric value."
   *
   * @param arg
   * @returns number
   */
  ToInteger: function (arg) {
    /* "1. Let number be the result of calling ToNumber on the input argument." */
    var number = es.ToNumber(arg);

    /* 2. If number is NaN, return +0. */
    if (isNaN(number))
    {
      return +0;
    }

    /* "3. If number is +0, −0, +inf, or −inf, return number." */
    if (number == 0 || !isFinite(number))
    {
      return number;
    }

    /* "4. Return the result of computing sign(number) × floor(abs(number))." */
    return es.sign(number) * es.floor(es.abs(number));
  },

  /**
   * "9.6 ToUint32
   *
   * The abstract operation ToUint32 converts its argument to one
   * of 2³² integer values in the range 0 through 2³²−1, inclusive."
   *
   * @param arg
   * @returns number
   */
  ToUint32: function (arg) {
    /* "1. Let number be the result of calling ToNumber on the input argument." */
    var number = es.ToNumber(arg);

    /* "2. If number is NaN, +0, −0, +inf, or −inf, return +0." */
    if (isNaN(number) || number === 0 || Math.abs(number) === Infinity)
    {
      return 0;
    }

    /* "3. Let posInt be sign(number) × floor(abs(number))." */
    var posInt = es.sign(arg) * Math.floor(Math.abs(number));

    /*
     * "4. Let int32bit be posInt modulo 2³²; that is, a
     *  finite integer value k of Number type with positive sign
     *  and less than 2³² in magnitude such that the mathematical
     *  difference of posInt and k is mathematically an integer
     *  multiple of 2³²."
     */
    var int32bit = posInt >>> 0;

    /* "5. Return int32bit." */
    return int32bit;
  },

  /**
   * "9.9 ToString
   *
   * The abstract operation ToString converts its argument to
   * a value of type String …"
   *
   * @param arg
   * @returns string
   */
  ToString: function (arg) {
    var t = es.Type(arg);

    if (t == es.T_UNDEFINED)
    {
      return "undefined";
    }

    if (t == es.T_NULL)
    {
      return "null";
    }

    if (t == es.T_BOOLEAN)
    {
      return (arg) ? "true" : "false";
    }

    if (t == es.T_NUMBER)
    {
      var m = arg;

      /* "1. If m is NaN, return the String "NaN"." */
      if (isNaN(m))
      {
        return "NaN";
      }

      /* "2. If m is +0 or −0, return the String "0"." */
      if (m == 0 || m == -0)
      {
        return "0";
      }

      /*
       * "3. If m is less than zero, return the String concatenation
       *     of the String "-" and ToString(−m)."
       */
      if (m < 0)
      {
        return "-" + es.ToString(-m);
      }

      /* "4. If m is infinity, return the String "Infinity"." */
      if (!isFinite(m))
      {
        return "Infinity";
      }

      /*
       * "5. Otherwise, let n, k, and s be integers such that
       *     k >= 1, 10^(k-1) <= s < 10^k, the Number value for
       *     s  10 is m, and k is as small as possible. Note that
       *     k is the number of digits in the decimal representation
       *     of s, that s is not divisible by 10, and that the least
       *     significant digit of s is not necessarily uniquely
       *     determined by these criteria.
       * 6. …"
       */
      /* TODO */
      return String(m);
    }

    if (t == es.T_STRING)
    {
      return arg;
    }

    if (t == es.T_OBJECT)
    {
      /* "1. Let primValue be ToPrimitive(input argument, hint String)." */
      var primValue = es.ToPrimitive(arg, es.T_STRING);

      /* "2. Return ToString(primValue)." */
      return es.ToString(primValue);
    }
  },

  /**
   * "9.9 To Object
   *
   * The abstract operation ToObject converts its argument to
   * a value of type Object …"
   *
   * @param arg
   * @returns Object
   */
  ToObject: function (arg) {
    var t = es.Type(arg);
    if (t === es.T_UNDEFINED || t === es.T_NULL)
    {
      throw new TypeError();
    }

    if (t === es.T_BOOLEAN)
    {
      return new Boolean(arg);
    }

    if (t === es.T_NUMBER)
    {
      return new Number(arg);
    }

    if (t === es.T_STRING)
    {
      return new String(arg);
    }

    if (t === es.T_OBJECT)
    {
      return arg;
    }
  },

  /**
   * Implements the "[[Class]] internal property" value in
   * ECMAScript algorithms.
   *
   * @param arg
   */
  getClass: function (arg) {
    return (({}).toString.call(arg).match(/\[object ([^\]]+)\]/) || [, ])[1];
  },

  /**
   * "9.10 CheckObjectCoercible
   * The abstract operation CheckObjectCoercible throws an error
   * if its argument is a value that cannot be converted to
   * an Object using ToObject. It is defined by Table 15:
   * <pre>
   * Argument Type  Result
   * --------------------------------------------
   * Undefined      Throw a TypeError exception.
   * Null           Throw a TypeError exception.
   * Boolean        Return
   * Number         Return
   * String         Return
   * Object         Return
   * </pre>"
   *
   * @param arg
   * @returns
   */
  CheckObjectCoercible: function (arg) {
    var t = es.Type(arg);

    if (t == es.T_UNDEFINED || t == es.T_NULL)
    {
      return jsx.throwThis("TypeError");
    }
  },

  /**
   * "9.11 IsCallable
   * The abstract operation IsCallable determines if its argument,
   * which must be an ECMAScript language value, is a callable
   * function Object according to Table 16:
   * <pre>
   * Argument Type    Result
   * -------------------------------------------------------------
   * Undefined        Return false.
   * Null             Return false.
   * Boolean          Return false.
   * Number           Return false.
   * String           Return false.
   * Object           If the argument object has a [[Call]]
   *                  internal method, then return true, otherwise
   *                  return false.
   * </pre>"
   * NOTE: Callable objects other than Function instances cannot
   * be recognized.
   */
  IsCallable: function (arg) {
    var t = es.Type(arg);

    if (t == es.T_UNDEFINED || t == es.T_NULL || t == es.T_BOOLEAN
        || t == es.T_NUMBER || t == es.T_STRING)
    {
      return false;
    }

    if (typeof arg == "function")
    {
      return true;
    }

    return false;
  },

  Array: {
    prototype: {
      /**
       * "When the splice method is called with two or more
       *  arguments start, deleteCount and (optionally) item1,
       *  item2, etc., the deleteCount elements of the array
       *  starting at array index start are replaced by
       *  the arguments item1, item2, etc. An Array object
       *  containing the deleted elements (if any) is returned."
       * @param start : int
       * @param deleteCount : int
       * @params items : Array[any]
       * @return Array
       */
      splice: function (start, deleteCount/*, items */) {
        /*
         * "1. Let O be the result of calling ToObject passing
         *     the this value as the argument."
         */
        var o = es.ToObject(this);

        /*
         * "2. Let A be a new array created as if by the expression
         *     new Array() where Array is the standard built-in
         *     constructor with that name."
         */
        var a = [];

        /*
         * 3. Let lenVal be the result of calling the [[Get]]
         *    internal method of O with argument "length ".
         */
        var lenVal = o.length;

        /* "4. Let len be ToUint32(lenVal). */
        var len = es.ToUint32(lenVal);

        /* "5. Let relativeStart be ToInteger(start)." */
        var relativeStart = es.ToInteger(start);

        /*
         * "6. If relativeStart is negative, let actualStart be
         *     max((len + relativeStart),0); else let actualStart
         *     be min(relativeStart, len).
         */
        var actualStart = (relativeStart < 0)
                         ? es.max((len + relativeStart), 0)
                         : es.min(relativeStart, len);

        /*
         * "7. Let actualDeleteCount be min(
         *     max(ToInteger(deleteCount),0), len – actualStart)."
         */
        var actualDeleteCount = es.min(
          es.max(es.ToInteger(deleteCount), 0),
          len - actualStart);

        /* "8. Let k be 0." */
        var k = 0;

        /* "9. Repeat, while k < actualDeleteCount" */
        while (k < actualDeleteCount)
        {
          /* "a. Let from be ToString(actualStart+k)." */
          var from = es.ToString(actualStart + k);

          /*
           * "b. Let fromPresent be the result of calling
           *     the [[HasProperty]] internal method of O
           *     with argument from."
           */
          var fromPresent = (from in o);

          /* "c. If fromPresent is true, then" */
          if (fromPresent === true)
          {
            /*
             * "i. Let fromValue be the result of calling
             *     the [[Get]] internal method of O with
             *     argument from."
             */
            var fromValue = o[from];

            /*
             * "ii. Call the [[DefineOwnProperty]] internal method
             *  of A with arguments ToString(k), Property Descriptor
             *  {[[Value]]: fromValue, [[Writable]]: true,
             *  [[Enumerable]]: true, [[Configurable]]: true},
             *  and false.
             */
            a[es.ToString(k)] = fromValue;

            /* "d. Increment k by 1." */
            ++k;
          }
        }

        /*
         * "10. Let items be an internal List whose elements are,
         *      in left to right order, the portion of the actual
         *      argument list starting with item1. The list will
         *      be empty if no such items are present.
         */
        var items = es.slice(arguments, 2, arguments.length);

        /* "11. Let itemCount be the number of elements in items." */
        var itemCount = items.length;

        /* "12. If itemCount < actualDeleteCount, then */
        if (itemCount < actualDeleteCount)
        {
          /* "a. Let k be actualStart." */
          k = actualStart;

          /* "b. Repeat, while k < (len – actualDeleteCount)" */
          while (k < (len - actualDeleteCount))
          {
            /* "i. Let from be ToString(k+actualDeleteCount)." */
            from = es.ToString(k + actualDeleteCount);

            /* "ii. Let to be ToString(k+itemCount)." */
            var to = es.ToString(k + itemCount);

            /*
             * "iii. Let fromPresent be the result of calling
             *       the [[HasProperty]] internal method of O
             *       with argument from.
             */
            fromPresent = (from in o);

            /*
             * iv. If fromPresent is true, then
             */
            if (fromPresent === true)
            {
              /*
               * 1. Let fromValue be the result of calling
               *    the [[Get]] internal method of O with
               *    argument from.
               */
              var fromValue = o[from];

              /*
               * 2. Call the [[Put]] internal method of O
               *    with arguments to, fromValue, and true
               */
              o[to] = fromValue;
            }
            /* "v. Else, fromPresent is false" */
            else if (fromPresent === false)
            {
              /* "1. Call the [[Delete]] internal method of O with arguments to and true." */
              delete o[to];
            }

            /* "vi. Increase k by 1. */
            ++k;
          }

          /* "c. Let k be len." */
          k = len;

          /* "d. Repeat, while k > (len – actualDeleteCount + itemCount)" */
          while (k > (len - actualDeleteCount + itemCount))
          {
            /* "i. Call the [[Delete]] internal method of O with arguments ToString(k–1) and true." */
            delete o[es.ToString(k - 1)];

            /* "ii. Decrease k by 1." */
            --k;
          }
        }
        /* "13. Else if itemCount > actualDeleteCount, then" */
        else
        {
          /* "a. Let k be (len – actualDeleteCount)." */
          k = (len - actualDeleteCount);

          /* "b. Repeat, while k > actualStart" */
          while (k > actualStart)
          {
            /* "i. Let from be ToString(k + actualDeleteCount – 1)." */
            from = es.ToString(k + actualDeleteCount - 1);

            /* "ii. Let to be ToString(k + itemCount – 1) */
            to = es.ToString(k + itemCount - 1);

            /*
             * "iii. Let fromPresent be the result of calling
             *       the [[HasProperty]] internal method of O
             *       with argument from."
             */
            fromPresent = (from in o);

            /* "iv. If fromPresent is true, then" */
            if (fromPresent === true)
            {
              /*
               * "1. Let fromValue be the result of calling
               *     the [[Get]] internal method of O with
               *     argument from."
               */
              fromValue = o[from];

              /*
               * "2. Call the [[Put]] internal method of O
               *     with arguments to, fromValue, and true."
               */
              o[to] = fromValue;
            }
            /* "v. Else, fromPresent is false" */
            else if (fromPresent === false)
            {
              /*
               * "1. Call the [[Delete]] internal method of O
               *     with argument to and true."
               */
              delete o[to];
            }

            /* "vi. Decrease k by 1. */
            --k;
          }
        }

        /* "14. Let k be actualStart." */
        k = actualStart;

        /* "15. Repeat, while items is not empty" */
        while (items.length > 0)
        {
          /*
           * "a. Remove the first element from items and let E
           *     be the value of that element."
           */
          var e = es.shift(items);

          /*
           * "b. Call the [[Put]] internal method of O
           *     with arguments ToString(k), E, and true."
           */
          o[es.ToString(k)] = e;

          /* "c. Increase k by 1." */
          ++k;
        }

        /*
         * "16. Call the [[Put]] internal method of O
         *      with arguments "length",
         *      (len – actualDeleteCount + itemCount), and true."
         */
        o.length = (len - actualDeleteCount + itemCount);

        /* 17. Return A. */
        return a;
      }
    }
  },

  Object: {
    keys: function (obj) {
      var a = [];

      for (var property in obj)
      {
        if (obj.hasOwnProperty(property))
        {
          a.push(property);
        }
      }

      return a;
    }
  },

  JSON: {
    parse: function (text, reviver) {
      /**
       * "The abstract operation Walk is a recursive abstract
       * operation that takes two parameters: a holder object and
       * the String name of a property in that object. Walk uses
       * the value of reviver that was originally passed to
       * the above parse function."
       *
       * @param holder : Object
       * @param name : String
       * @returns mixed
       */
      function Walk (holder, name)
      {
        /*
         * "1. Let val be the result of calling the [[Get]]
         *     internal method of holder with argument name."
         */
        var val = holder[name];

        /* "2. If val is an object, then" */
        if (es.isObject(val))
        {
          var Class = es.getClass(val);

          /* "a. If the [[Class]] internal property of val is "Array"" */
          if (Class == "Array")
          {
            /* "i. Set I to 0." */
            var I = 0;

            /*
             * "ii. Let len be the result of calling the [[Get]]
             *      internal method of val with argument "length"."
             */
            var len = val.length;

            /* "iii. Repeat while I < len," */
            while (I < len)
            {
              /*
               * "1. Let newElement be the result of calling
               *     the abstract operation Walk, passing val
               *     and ToString(I)."
               */
              var newElement = Walk(val, es.ToString(I));

              /* "2. If newElement is undefined, then" */
              if (typeof newElement == "undefined")
              {
                /* "a  Call the [[Delete]] internal method of val
                 *     with ToString(I) and false as arguments."
                 */
                delete val[I];
              }
              /* "3. Else" */
              else
              {
                /*
                 * "a  Call the [[DefineOwnProperty]] internal
                 *     method of val with arguments ToString(I),
                 *     the Property Descriptor
                 *     {[[Value]]: newElement, [[Writable]]: true,
                 *     [[Enumerable]]: true,
                 *     [[Configurable]]: true}, and false."
                 */
                val[I] = newElement;
              }

              /* "4. Add 1 to I." */
              ++I;
            }
          }
          /* "b. Else" */
          else
          {
            /*
             * "i. Let keys be an internal List of String values
             *     consisting of the names of all the own properties
             *     of val whose [[Enumerable]] attribute is true.
             *     The ordering of the Strings should be the same
             *     as that used by the Object.keys standard built-in
             *     function."
             */
            var keys = es.Object.keys(val);

            /* "ii. For each String P in keys do" */
            for (var P in keys)
            {
              /*
               * "1. Let newElement be the result of calling
               *     the abstract operation Walk, passing val
               *     and P."
               */
              var newElement = Walk(val, P);

              /* "2. If newElement is undefined, then" */
              if (typeof newElement == "undefined")
              {
                /*
                 * "a  Call the [[Delete]] internal method of val
                 *     with P and false as arguments."
                 */
                delete val[P];
              }
              /* "3. Else" */
              else
              {
                /*
                 * "a  Call the [[DefineOwnProperty]] internal
                 *     method of val with arguments P, the
                 *     Property Descriptor {[[Value]]: newElement,
                 *     [[Writable]]: true, [[Enumerable]]: true,
                 *     [[Configurable]]: true}, and false."
                 */
                val[P] = newElement;
              }
            }
          }
        }

        /*
         * "3. Return the result of calling the [[Call]] internal
         *     method of reviver passing holder as the this value
         *     and with an argument list consisting of name and val."
         */
        return reviver.call(holder, name, val);
      }

      /* "1. Let JText be ToString(text)." */
      var JText = es.ToString(text);

      /*
       * "2. Parse JText using the grammars in 15.12.1. Throw a
       *     SyntaxError exception if JText did not conform to
       *     the JSON grammar for the goal symbol JSONText."
       */
      /* TODO */

      /*
       * "3. Let unfiltered be the result of parsing and evaluating
       *     JText as if it was the source text of an ECMAScript
       *     Program but using JSONString in place of StringLiteral.
       *     Note that since JText conforms to the JSON grammar this
       *     result will be either a primitive value or an object
       *     that is defined by either an ArrayLiteral or an
       *     ObjectLiteral."
       */
      var unfiltered = eval("(" + text + ")");

      /* "4. If IsCallable(reviver) is true, then" */
      if (es.IsCallable(reviver))
      {
        var root = {};
        root[""] = unfiltered;
        return Walk(root, "");
      }
      /* "5. Else" */
      {
        /* "a. Return unfiltered." */
        return unfiltered;
      }
    },

    stringify: function (value, replacer, space) {
      /**
       * "The abstract operation Quote(value) wraps a String value
       *  in double quotes and escapes characters within it."
       *
       * @param value : String
       */
      function Quote (value)
      {
        /* "1. Let product be the double quote character." */
        var product = '"';

        /* "2. For each character C in value" */
        for (var i = 0, len = value.length; i < len; ++i)
        {
          var C = value.charAt(i);

          /*
           * "a. If C is the double quote character or
           *     the backslash character"
           */
          if (C == '"' || C == "\\")
          {
            /*
             * "i. Let product be the concatenation of product and
             *     the backslash character."
             */
            product += "\\";

            /* "ii. Let product be the concatenation of product and C." */
            product += C;
          }
          /* "b. Else if C is backspace, formfeed, newline, carriage return, or tab" */
          else if (C == "\u0008" || C == "\u000C" || C == "\u000A"
                    || C == "\u000D" || C == "\u0009")
          {
            /* "i. Let product be the concatenation of product and the backslash character." */
            product += "\\";

            /*
             * "ii. Let abbrev be the character corresponding to
             * the value of C as follows:
             *
             * backspace          "b"
             * formfeed           "f"
             * newline            "n"
             * carriage return    "r"
             * tab                "t""
             */
            var map = {
              "\u0008": "b",
              "\u000C": "f",
              "\u000A": "n",
              "\u000D": "r",
              "\u0009": "t"
            };
            var abbrev = map[C];

            /*
             * "iii. Let product be the concatenation of product
             *       and abbrev."
             */
            product += abbrev;
          }
          /*
           * "c. Else if C is a control character having a code unit
           *     value less than the space character"
           */
          else if (C < " ")
          {
            /*
             * "i. Let product be the concatenation of product and
             *     the backslash character."
             */
            product += "\\";

            /*
             * "ii. Let product be the concatenation of product and
             *      "u"."
             */
            product += "u";

            /*
             * "iii. Let hex be the result of converting the numeric
             *       code unit value of C to a String of four
             *       hexadecimal digits."
             */
            var hex = C.charCodeAt(0).toString(16);
            var len = hex.length;
            if (len < 4)
            {
              var a = [];
              a.length = (4 - len) + 1;
              hex = a.join("0") + hex;
            }

            /* "iv. Let product be the concatenation of product and hex." */
            product += hex;
          }
          /* d. Else */
          else
          {
            /* "i. Let product be the concatenation of product and C." */
            product += C;
          }
        }

        /* "3. Let product be the concatenation of product and the double quote character." */
        product += '"';

        /* "4. Return product." */
        return product;
      }

      /**
       * "The abstract operation JO(value) serializes an object. It has access
       * to the stack, indent, gap, PropertyList, ReplacerFunction, and space
       * of the invocation of the stringify method."
       *
       * @param value : Object
       */
      function JO (value)
      {
        /*
         *  "1. If stack contains value then throw a TypeError
         *     exception because the structure is cyclical."
         */
        if (stack.indexOf(value) > -1)
        {
          eval("throw new TypeError();");
        }

        /* "2. Append value to stack." */
        stack.push(value);

        /* "3. Let stepback be indent." */
        var stepback = indent;

        /* "4. Let indent be the concatenation of indent and gap." */
        indent += gap;

        /* "5. If PropertyList is not undefined, then" */
        if (typeof PropertyList != "undefined")
        {
          /* "a. Let K be PropertyList." */
          var K = PropertyList;
        }
        /* "6. Else" */
        else
        {
          /* "a. Let K be an internal List of Strings consisting
           *     of the names of all the own properties of value
           *     whose [[Enumerable]] attribute is true. The
           *     ordering of the Strings should be the same as
           *     that used by the Object.keys standard built-in
           *     function."
           */
          K = Object.keys(value);
        }

        /* "7. Let partial be an empty List." */
        var partial = [];

        /* "8. For each element P of K." */
        for (var i = 0, len = K.length; i < len; ++i)
        {
          var P = K[i];

          /* "a. Let strP be the result of calling the abstract
           *     operation Str with arguments P and value."
           */
          var strP = Str(P, value);

          /* "b. If strP is not undefined" */
          if (typeof strP != "undefined")
          {
            /*
             * "i. Let member be the result of calling the abstract
             *     operation Quote with argument P."
             */
            var member = Quote(P);

            /*
             * "ii. Let member be the concatenation of member and
             * the colon character."
             */
            member += ":";

            /* "iii. If gap is not the empty String" */
            if (gap != "")
            {
              /*
               * "1. Let member be the concatenation of member and
               *     the space character."
               */
              member += " ";
            }

            /* "iv. Let member be the concatenation of member and strP." */
            member += strP;

            /* "v. Append member to partial." */
            partial.push(member);
          }
        }

        /* "9. If partial is empty, then" */
        if (partial.length == 0)
        {
          /* "a. Let final be "{}"." */
          var _final = "{}";
        }
        /* "10. Else" */
        else
        {
          /* "a. If gap is the empty String" */
          if (gap == "")
          {
            /*
             * "i. Let properties be a String formed by
             *     concatenating all the element Strings of partial
             *     with each adjacent pair of Strings separated
             *     with the comma character. A comma is not
             *     inserted either before the first String or after
             *     the last String."
             */
            var properties = partial.join(",");

            /*
             * "ii. Let final be the result of concatenating "{",
             *      properties, and "}"."
             */
            _final = "{" + properties + "}";
          }
          /* "b. Else gap is not the empty String" */
          else
          {
            /*
             * "i. Let separator be the result of concatenating
             *     the comma character, the line feed character,
             *     and indent."
             */
            var separator = ",\u000A" + indent;

            /*
             * "ii. Let properties be a String formed by
             *      concatenating all the element Strings of
             *      partial with each adjacent pair of Strings
             *      separated with separator. The separator String
             *      is not inserted either before the first String
             *      or after the last String."
             */
            properties = partial.join(separator);

            /*
             * "iii. Let final be the result of concatenating "{",
             *       the line feed character, indent, properties,
             *       the line feed character, stepback, and "}"."
             */
            _final = "{\u000A" + indent + properties + "\u000A" + stepback + "}";
          }
        }

        /* "11. Remove the last element of stack." */
        stack.pop();

        /* "12. Let indent be stepback." */
        indent = stepback;

        /* "13. Return final." */
        return _final;
      }

      /**
       * "The abstract operation JA(value) serializes an array.
       *  It has access the stack, indent, gap, and space of
       *  the invocation of the stringify method. The representation
       *  of arrays includes only the elements between zero and
       *  array.length – 1 inclusive. Named properties are excluded
       *  from the stringification. An array is stringified as an
       *  open left bracket, elements separated by comma, and a
       *  closing right bracket."
       *
       * @param value : Array
       */
      function JA (value)
      {
        /*
         * "1. If stack contains value then throw a TypeError exception
         *     because the structure is cyclical."
         */
        if (stack.indexOf(value) > -1)
        {
          eval("throw new TypeError();");
        }

        /* "2. Append value to stack." */
        stack.push(value);

        /* "3. Let stepback be indent." */
        var stepback = indent;

        /* "4. Let indent be the concatenation of indent and gap." */
        indent += gap;

        /* "5. Let partial be an empty List." */
        var partial = [];

        /*
         * "6. Let len be the result of calling the [[Get]] internal
         *     method of value with argument "length"."
         */
        var len = value.length;

        /* "7. Let index be 0." */
        var index = 0;

        /* "8. Repeat while index < len" */
        while (index < len)
        {
          /*
           * "a. Let strP be the result of calling the abstract
           *     operation Str with arguments ToString(index) and
           *     value."
           */
          var strP = Str(es.ToString(index), value);

          /* "b. If strP is undefined" */
          if (typeof strP == "undefined")
          {
            /* i. Append "null" to partial. */
            partial.push("null");
          }
          /* "c. Else" */
          else
          {
            /* "i. Append strP to partial." */
            partial.push(strP);
          }

          /* "d. Increment index by 1." */
          ++index;
        }

        /* "9. If partial is empty, then" */
        if (partial.length == 0)
        {
          /* "a. Let final be "[]"." */
          var _final = "[]";
        }
        /* "10. Else" */
        else
        {
          /* "a. If gap is the empty String" */
          if (gap == "")
          {
            /* "i. Let properties be a String formed by concatenating
             *     all the element Strings of partial with each
             *     adjacent pair of Strings separated with
             *     the comma character. A comma is not inserted
             *     either before the first String or after the last
             *     String."
             */
            var properties = partial.join(",");

            /* "ii. Let final be the result of concatenating "[",
             *      properties, and "]"."
             */
            _final = "[" + properties + "]";
          }
          /* "b. Else" */
          else
          {
            /*
             * "i. Let separator be the result of concatenating
             *     the comma character, the line feed character,
             *     and indent."
             */
            var separator = ",\u000A" + indent;

            /*
             * "ii. Let properties be a String formed by
             *      concatenating all the element Strings of
             *      partial with each adjacent pair of Strings
             *      separated with separator. The separator String
             *      is not inserted either before the first String
             *      or after the last String."
             */
            properties = partial.join(separator);

            /*
             * "iii. Let final be the result of concatenating "[",
             *       the line feed character, indent, properties,
             *       the line feed character, stepback, and "]"."
             */
            _final = "[\u000A" + indent + properties + "\u000A" + stepback + "]";
          }
        }

        /* "11. Remove the last element of stack." */
        stack.pop();

        /* "12. Let indent be stepback." */
        indent = stepback;

        /* "13. Return final." */
        return _final;
      }

      /**
       * "The abstract operation Str(key, holder) has access
       *  to ReplacerFunction from the invocation of the stringify
       *  method."
       *
       * @param key : string
       * @param holder : Object
       * @returns string
       */
      function Str (key, holder)
      {
        /*
         * "1. Let value be the result of calling the [[Get]]
         *     internal method of holder with argument key."
         */
        var value = holder[key];

        /* "2. If Type(value) is Object, then" */
        if (es.Type(value) == es.T_OBJECT)
        {
          /*
           * "a. Let toJSON be the result of calling the [[Get]]
           *     internal method of value with argument "toJSON".
           */
          var toJSON = value.toJSON;

          /* "b. If IsCallable(toJSON) is true" */
          if (es.IsCallable(toJSON))
          {
            /*
             * "i. Let value be the result of calling the [[Call]]
             *     internal method of toJSON passing value as the
             *     this value and with an argument list consisting
             *     of key."
             */
            value = toJSON.call(value, key);
          }
        }

        /* "3. If ReplacerFunction is not undefined, then" */
        if (typeof ReplacerFunction != "undefined")
        {
          /*
           * "a. Let value be the result of calling the [[Call]]
           *     internal method of ReplacerFunction passing holder
           *     as the this value and with an argument list
           *     consisting of key and value."
           */
          value = ReplacerFunction.call(holder, key, value);
        }

        /* "4. If Type(value) is Object then," */
        if (es.Type(value) == es.T_OBJECT)
        {
          /*
           * "a. If the [[Class]] internal property of value is
           *     "Number" then,"
           */
          var _class = es.getClass(value);
          if (_class == "Number")
          {
            /* "i. Let value be ToNumber(value)." */
            value = es.ToNumber(value);
          }
          /*
           * "b. Else if the [[Class]] internal property of value
           *     is "String" then,"
           */
          else if (_class == "String")
          {
            /* "i. Let value be ToString(value)." */
            value = es.ToString(value);
          }
          /*
           * "c. Else if the [[Class]] internal property of value
           *     is "Boolean" then,"
           */
          else if (_class == "Boolean")
          {
            /*
             * "i. Let value be the value of the [[PrimitiveValue]]
             * internal property of value."
             */
            value = value.valueOf();
          }
        }

        /* "5. If value is null then return "null"." */
        if (value === null)
        {
          return "null";
        }

        /* "6. If value is true then return "true"." */
        if (value === true)
        {
          return "true";
        }

        /* "7. If value is false then return "false"." */
        if (value === false)
        {
          return "false";
        }

        var t = es.Type(value);

        /*
         * "8. If Type(value) is String, then return the result of
         *     calling the abstract operation Quote with argument
         *     value."
         */
        if (t == es.T_STRING)
        {
          return Quote(value);
        }

        /* "9. If Type(value) is Number" */
        if (t == es.T_NUMBER)
        {
          /*
           * "a. If value is finite then return ToString(value).
           *  b. Else, return "null"."
           */
          return isFinite(value) ? es.ToString(value) : "null";
        }

        /* "10. If Type(value) is Object, and IsCallable(value) is false" */
        if (t == es.T_OBJECT && !es.IsCallable(value))
        {
          /*
           * "a. If the [[Class]] internal property of value is
           *     "Array" then" */
          if (es.getClass(value) == "Array")
          {
            /*
             * "i. Return the result of calling the abstract
             *     operation JA with argument value."
             */
            return JA(value);
          }

          /*
           *  "b. Else, return the result of calling the abstract
           *     operation JO with argument value."
           */
          return JO(value);
        }

        /* "11. Return undefined." */
        return void 0;
      }

      /* "1. Let stack be an empty List." */
      var stack = [];

      /* "2. Let indent be the empty String." */
      var indent = "";

      /* "3. Let PropertyList and ReplacerFunction be undefined." */
      var PropertyList, ReplacerFunction;

      /* "4. If Type(replacer) is Object, then" */
      if (es.Type(replacer) == es.T_OBJECT)
      {
        var Class = es.getClass(replacer);

        /* "a. If IsCallable(replacer) is true, then" */
        if (es.isCallable(replacer))
        {
          /* "i. Let ReplacerFunction be replacer." */
          ReplacerFunction = replacer;
        }
        /*
         * "b. Else if the [[Class]] internal property of replacer
         *     is "Array", then" */
        else if (Class == "Array")
        {
          /* "i. Let PropertyList be an empty internal List" */
          PropertyList = [];

          /*
           * "ii. For each value v of a property of replacer that
           *      has an array index property name. The properties
           *      are enumerated in the ascending array index order
           *      of their names."
           */
          for (var propertyName = 0, maxIdx = Math.pow(2, 32) - 1;
                propertyName <= maxIdx; ++propertyName)
          {
            var v = replacer[propertyName];

            /* "1. Let item be undefined." */
            var item = void 0;

            /* "2. If Type(v) is String then let item be v." */
            var t = es.Type(v);
            if (t == "String")
            {
              item = v;
            }
            /* "Else if Type(v) is Number then let item be ToString(v)." */
            else if (t == es.T_NUMBER)
            {
              item = es.ToString(v);
            }
            /* "4. Else if Type(v) is Object then,"  */
            else if (t == es.T_OBJECT)
            {
              /*
               * "a  If the [[Class]] internal property of v
               *     is "String" or "Number" then let item be
               *     ToString(v)."
               */
              var _class = es.getClass(v);
              if (_class == "String" || _class == "Number")
              {
                item = es.ToString(v);
              }
            }

            /*
             * "5. If item is not undefined and item is not
             *     currently an element of PropertyList then,
             *     a  Append item to the end of PropertyList."
             */
            if (typeof item != "undefined"
                && PropertyList.indexOf(item) < 0)
            {
              PropertyList.push(item);
            }
          }
        }
      }

      /* "5. If Type(space) is Object then," */
      t = es.Type(space);
      if (t == es.T_OBJECT)
      {
        /*
         * "a. If the [[Class]] internal property of space is
         *     "Number" then," */
        var _class = es.getClass(space);
        if (_class == "Number")
        {
          /* "i. Let space be ToNumber(space)." */
          space = es.ToNumber(space);
        }
        /*
         * "b. Else if the [[Class]] internal property of space
         *     is "String" then,"
         */
        else if (_class == "String")
        {
          /* "i. Let space be ToString(space)." */
          space = es.ToString(space);
        }
      }

      /* "6. If Type(space) is Number" */
      if (t == es.T_NUMBER)
      {
        /* "a. Let space be min(10, ToInteger(space))." */
        space = es.min(10, es.ToInteger(space));

        /*
         * "b. Set gap to a String containing space space characters.
         *     This will be the empty String if space is less than 1."
         */
        var gap = es.repeat(" ", space);
      }
      /* "7. Else if Type(space) is String" */
      else if (t == "String")
      {
        /*
         * "a. If the number of characters in space is 10 or less,
         *     set gap to space otherwise set gap to a String
         *     consisting of the first 10 characters of space."
         */
        gap = space.slice(0, 10);
      }
      /* "8. Else" */
      else
      {
        /* "a. Set gap to the empty String." */
        gap = "";
      }

      /*
       * "9. Let wrapper be a new object created as if by
       *     the expression new Object(), where Object is
       *     the standard built-in constructor with that name."
       */
      var wrapper = {};

      /*
       * "10. Call the [[DefineOwnProperty]] internal method of
       *      wrapper with arguments the empty String,
       *      the Property Descriptor {[[Value]]: value,
       *      [[Writable]]: true, [[Enumerable]]: true,
       *      [[Configurable]]: true}, and false."
       */
      wrapper[""] = value;

      /*
       * "11. Return the result of calling the abstract operation
       *      Str with the empty String and wrapper."
       */
      return Str("", wrapper);
    }
  }
};