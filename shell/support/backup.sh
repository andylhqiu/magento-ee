#!/bin/bash
#
# Magento Enterprise Edition
#
# NOTICE OF LICENSE
#
# This source file is subject to the Magento Enterprise Edition End User License Agreement
# that is bundled with this package in the file LICENSE_EE.txt.
# It is also available through the world-wide-web at this URL:
# http://www.magento.com/license/enterprise-edition
# If you did not receive a copy of the license and are unable to
# obtain it through the world-wide-web, please send an email
# to license@magento.com so we can send you a copy immediately.
#
# DISCLAIMER
#
# Do not edit or add to this file if you wish to upgrade Magento to newer
# versions in the future. If you wish to customize Magento for your
# needs please refer to http://www.magento.com for more information.
#
# @category    Mage
# @package     Mage_Shell
# @copyright Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
# @license http://www.magento.com/license/enterprise-edition
#

################################################################################
# FUNCTIONS
################################################################################

# 1. Check required system tools
_check_installed_tools() {
    local missed=""

    until [ -z "$1" ]; do
        type -t $1 >/dev/null 2>/dev/null
        if (( $? != 0 )); then
            missed="$missed $1"
        fi
        shift
    done

    echo $missed
}

# 2. Selftest for checking tools which will used
checkTools() {
    REQUIRED_UTILS='nice sed tar mysqldump head gzip getopt lsof'
    MISSED_REQUIRED_TOOLS=`_check_installed_tools $REQUIRED_UTILS`
    if (( `echo $MISSED_REQUIRED_TOOLS | wc -w` > 0 ));
    then
        echo -e "Unable to create backup due to missing required bash tools: $MISSED_REQUIRED_TOOLS"
        exit 1
    fi
}

# 3. Create code dump function
createCodeDump() {
    # Content of file archive
    DISTR="
    app
    downloader
    errors
    includes
    js
    lib
    pkginfo
    shell
    skin
    .htaccess
    cron.php
    get.php
    index.php
    install.php
    mage
    *.patch
    *.sh
    var/log/system.log
    var/log/exception.log
    var/log/shipping*.log
    var/log/payment*.log
    var/log/paypal*.log"

    # Create code dump
    DISTRNAMES=
    for ARCHPART in $DISTR; do
        if [ -r "$MAGENTOROOT$ARCHPART" ]; then
            DISTRNAMES="$DISTRNAMES $MAGENTOROOT$ARCHPART"
        fi
    done
    if [ -n "$DISTRNAMES" ]; then
        echo nice -n 15 tar -czhf $CODEFILENAME $DISTRNAMES
        nice -n 15 tar -czhf $CODEFILENAME $DISTRNAMES
    fi
}

# 4. Create DB dump function
createDbDump() {
    # Set path of local.xml
    LOCALXMLPATH=${MAGENTOROOT}app/etc/local.xml

    # Get mysql credentials from local.xml
    getLocalValue() {
        PARAMVALUE=`sed -n "/<resources>/,/<\/resources>/p" $LOCALXMLPATH | sed -n -e "s/.*<$PARAMNAME><!\[CDATA\[\(.*\)\]\]><\/$PARAMNAME>.*/\1/p" | head -n 1`
    }

    # Connection parameters
    DBHOST=
    DBUSER=
    DBNAME=
    DBPASSWORD=
    TBLPRF=

    # Include DB logs option
    SKIPLOGS=1

    # Ignored table names
    IGNOREDTABLES="
    core_cache
    core_cache_option
    core_cache_tag
    core_session
    log_customer
    log_quote
    log_summary
    log_summary_type
    log_url
    log_url_info
    log_visitor
    log_visitor_info
    log_visitor_online
    enterprise_logging_event
    enterprise_logging_event_changes
    index_event
    index_process_event
    report_event
    report_viewed_product_index
    dataflow_batch_export
    dataflow_batch_import
    enterprise_support_backup
    enterprise_support_backup_item"

    # Sanitize data
    SANITIZE=1

    # Sanitazed tables
    SANITIZEDTABLES="
    customer_entity
    customer_entity_varchar
    customer_address_entity
    customer_address_entity_varchar"

    # Get DB HOST from local.xml
    if [ -z "$DBHOST" ]; then
        PARAMNAME=host
        getLocalValue
        DBHOST=$PARAMVALUE
    fi

    # Get DB USER from local.xml
    if [ -z "$DBUSER" ]; then
        PARAMNAME=username
        getLocalValue
        DBUSER=$PARAMVALUE
    fi

    # Get DB PASSWORD from local.xml
    if [ -z "$DBPASSWORD" ]; then
        PARAMNAME=password
        getLocalValue
        DBPASSWORD=${PARAMVALUE//\"/\\\"}
    fi

    # Get DB NAME from local.xml
    if [ -z "$DBNAME" ]; then
        PARAMNAME=dbname
        getLocalValue
        DBNAME=$PARAMVALUE
    fi

    # Get DB TABLE PREFIX from local.xml
    if [ -z "$TBLPRF" ]; then
        PARAMNAME=table_prefix
        getLocalValue
        TBLPRF=$PARAMVALUE
    fi

    # Check DB credentials for existsing
    if [ -z "$DBHOST" -o -z "$DBUSER" -o -z "$DBNAME" ]; then
        echo "Skip DB dumping due lack of parameters host=$DBHOST; username=$DBUSER; dbname=$DBNAME;";
        exit 0
    fi

    # Set connection params
    if [ -n "$DBPASSWORD" ]; then
        CONNECTIONPARAMS=" -u$DBUSER -h$DBHOST -p\"$DBPASSWORD\" $DBNAME --force --triggers --single-transaction --opt --skip-lock-tables"
    else
        CONNECTIONPARAMS=" -u$DBUSER -h$DBHOST $DBNAME --force --triggers --single-transaction --opt --skip-lock-tables"
    fi

    # Create DB dump
    IGN_SCH=
    IGN_IGN=
    SAN_CMD=

    if [ -n "$SANITIZE" ] ; then

        for TABLENAME in $SANITIZEDTABLES; do
            SAN_CMD="$SAN_CMD $TBLPRF$TABLENAME"
            IGN_IGN="$IGN_IGN --ignore-table='$DBNAME'.'$TBLPRF$TABLENAME'"
        done
        PHP_CODE='
        while ($line=fgets(STDIN)) {
            if (preg_match("/(^INSERT INTO\s+\S+\s+VALUES\s+)\((.*)\);$/",$line,$matches)) {
                $row = str_getcsv($matches[2],",","\x27");
                foreach($row as $key=>$field) {
                    if ($field == "NULL") {
                        continue;
                    } elseif ( preg_match("/[A-Z]/i", $field)) {
                        $field = md5($field . rand());
                    }
                    $row[$key] = "\x27" . $field . "\x27";
                }
                echo $matches[1] . "(" . implode(",", $row) . ");\n";
                continue;
            }
            echo $line;
        }'
        SAN_CMD="nice -n 15 mysqldump $CONNECTIONPARAMS --skip-extended-insert $SAN_CMD | php -r '$PHP_CODE' ;"
    fi

    if [ -n "$SKIPLOGS" ] ; then
        for TABLENAME in $IGNOREDTABLES; do
            IGN_SCH="$IGN_SCH $TBLPRF$TABLENAME"
            IGN_IGN="$IGN_IGN --ignore-table='$DBNAME'.'$TBLPRF$TABLENAME'"
        done
        IGN_SCH="nice -n 15 mysqldump --no-data $CONNECTIONPARAMS $IGN_SCH ;"
    fi

    IGN_IGN="nice -n 15 mysqldump $CONNECTIONPARAMS $IGN_IGN"

    DBDUMPCMD="( $SAN_CMD $IGN_SCH $IGN_IGN) | sed -e 's/DEFINER[ ]*=[ ]*[^*]*\*/\*/' | gzip > $DBFILENAME"

    echo ${DBDUMPCMD//"p\"$DBPASSWORD\""/p[******]}

    eval "$DBDUMPCMD"
}

################################################################################
# CODE
################################################################################

# Selftest
checkTools

# Magento folder
MAGENTOROOT=./

# Output path
OUTPUTPATH=$MAGENTOROOT

# Input parameters
MODE=
NAME=

OPTS=`getopt -o m:n:o: -l mode:,name:,outputpath: -- "$@"`

if [ $? != 0 ]
then
    exit 1
fi

eval set -- "$OPTS"

while true ; do
    case "$1" in
        -m|--mode) MODE=$2; shift 2;;
        -n|--name) NAME=$2; shift 2;;
        -o|--outputpath) OUTPUTPATH=$2; shift 2;;
        --) shift; break;;
    esac
done

if [ -n "$NAME" ]; then
    CODEFILENAME="$OUTPUTPATH$NAME.tar.gz"
    DBFILENAME="$OUTPUTPATH$NAME.sql.gz"
else
    # Get random file name - some secret link for downloading from magento instance :)
    MD5=`echo \`date\` $RANDOM | md5sum | cut -d ' ' -f 1`
    DATETIME=`date -u +"%Y%m%d%H%M"`
    CODEFILENAME="$OUTPUTPATH$MD5.$DATETIME.tar.gz"
    DBFILENAME="$OUTPUTPATH$MD5.$DATETIME.sql.gz"
fi

if [ -n "$MODE" ]; then
    case $MODE in
        db) createDbDump; exit 0;;
        code) createCodeDump; exit 0;;
        check) exit 0;;
        *) echo Invalid mode; exit 1;;
    esac
fi

createCodeDump
createDbDump

exit 0
