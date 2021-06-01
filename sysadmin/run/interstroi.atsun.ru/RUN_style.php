<style type="text/css">
a.readsheet {
    display: inline-block; 
    margin-top: 20px;
width: 120px;
height: 120px;

background-repeat     : no-repeat;
background-size       : cover;
background-position-x : 50%;
background-position-y : 50%;
   }    
   a.readsheet      { background: url(<?=$DR.$ICON?>knife.gif);}

.abs {
    clear: both;
    display: none;
    height: 4px;
    position: absolute;
    left: 8px;
    top: 20px;
    filter: alpha(Opacity=80);
    opacity: 0.8; 
}
.abs1 {
    clear: both;
    display: none;
    height: 4px;
    left: 20px;
    top: 10px;
    filter: alpha(Opacity=10);
    opacity: 0.1; 
}
.content {
    clear: both;
    margin: 8px;
}    
    
.typefile {
    display: none;    
    }	
.upload {
    border: 1px solid #ccc;
    border-radius: 50px;
    cursor: pointer;
	display: inline-block;
	padding: 10px;
}

.loaderr_scan {
    background-color: rgba(0, 0, 0, 0.05) !important;
    display: none;
    float: left;
    height: 2px;
    margin-left: 10px;
    margin-top: 30px;
    position: relative;
    width: 50%;
}
.loaderr_scan .scap_load__ {
    background-color: #ebcd15;
    height: 4px;
    left: 0;
    position: absolute;
    top: 0;
    transition: all 0s ease 0s, all 2s ease 0s;
}	
	
</style>