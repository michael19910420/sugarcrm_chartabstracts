<?php
/*
Copyright 2011 John Mertic. All rights reserved.

Redistribution and use in source and binary forms, with or without modification, are
permitted provided that the following conditions are met:

   1. Redistributions of source code must retain the above copyright notice, this list of
      conditions and the following disclaimer.

   2. Redistributions in binary form must reproduce the above copyright notice, this list
      of conditions and the following disclaimer in the documentation and/or other materials
      provided with the distribution.

THIS SOFTWARE IS PROVIDED BY JOHN MERTIC ``AS IS'' AND ANY EXPRESS OR IMPLIED
WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND
FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL <COPYRIGHT HOLDER> OR
CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF
ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

The views and conclusions contained in the software and documentation are those of the
authors and should not be interpreted as representing official policies, either expressed
or implied, of John Mertic.
*/

require_once('include/Dashlets/DashletGenericChart.php'); 
require_once('include/SugarCharts/SugarChartFactory.php'); 
        
abstract class DashletGenericBarChart extends DashletGenericChart 
{  
    /**
     * Label that goes below the chart and above the legend
     *
     * @var string
     */
    protected $subtitle = '';
    
    /** 
     * Don't override this method, since it does all the work of actually rendering the chart.
     *
     * @see DashletGenericChart::display() 
     */ 
    public function display() 
    { 
        $sugarChart = SugarChartFactory::getInstance(); 
        $sugarChart->setProperties('', $this->subtitle, 'bar chart'); 
        $sugarChart->base_url   = array(); 
        $sugarChart->group_by   = array(); 
        $sugarChart->url_params = array();
        $sugarChart->setData($this->getDataset());
        $xmlFile = $sugarChart->getXMLFileName($this->id); 
        $sugarChart->saveXMLFile($xmlFile, $sugarChart->generateXML()); 
     
        return '<div align="center">' . 
            $sugarChart->display($this->id, $xmlFile, '100%', '480', false) . 
            '</div>' . 
            $this->processAutoRefresh(); 
    } 

    /** 
     * This is the format of the data returned
     *
     * <code>
     * <?php
     * array(
     *   '<Field1DisplayName>' => 5,
     *   '<Field2DisplayName>' => 6,
     *   );
     * ?>
     * </code>
     *
     * @return array
     */ 
    abstract protected function getDataset();
}  
